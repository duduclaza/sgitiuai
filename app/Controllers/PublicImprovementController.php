<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Department;
use App\Models\Improvement;
use App\Services\AuditLogger;

class PublicImprovementController extends Controller
{
    private array $priorities = ['Baixa', 'Média', 'Alta', 'Crítica'];

    public function index(): void
    {
        $model = new Improvement();
        $ticket = (string) ($_GET['ticket'] ?? '');
        $lookup = null;
        $notFound = false;

        if ($ticket !== '') {
            $lookup = $model->findByTicket($ticket);
            $notFound = $lookup === null;
        }

        $this->render($lookup, $notFound, $ticket);
    }

    public function store(): void
    {
        verify_csrf();

        $title = trim((string) ($_POST['titulo'] ?? ''));
        $name = trim((string) ($_POST['responsavel_nome'] ?? ''));
        $problem = trim((string) ($_POST['descricao_problema'] ?? ''));

        if ($title === '' || $name === '' || $problem === '') {
            $this->publicBackWithError('Preencha título, seu nome e descrição do problema para enviar a melhoria.');
        }

        $departmentId = ($_POST['departamento_id'] ?? '') !== '' ? (int) $_POST['departamento_id'] : null;
        $priority = (string) ($_POST['prioridade'] ?? 'Média');
        if (!in_array($priority, $this->priorities, true)) {
            $priority = 'Média';
        }

        $model = new Improvement();
        $created = $model->createWithTicket([
            'titulo' => $title,
            'departamento_id' => $departmentId,
            'descricao_problema' => $problem,
            'melhoria_sugerida' => trim((string) ($_POST['melhoria_sugerida'] ?? '')),
            'prioridade' => $priority,
            'status' => 'Aberta',
            'responsavel_id' => null,
            'responsavel_nome' => $name,
            'prazo' => null,
            'ganho_estimado' => 0,
            'data_abertura' => date('Y-m-d'),
            'data_conclusao' => null,
            'causa_raiz' => trim((string) ($_POST['causa_raiz'] ?? '')),
            'observacoes' => trim((string) ($_POST['observacoes'] ?? '')),
            'criado_por' => null,
        ]);

        AuditLogger::log('criação pública', 'melhorias', $created['id'], [
            'titulo' => $title,
            'ticket' => $created['ticket'],
        ]);

        flash('success', 'Melhoria enviada com sucesso. Guarde seu ticket: ' . $created['ticket'] . '.');
        redirect('/melhoria-publica?tab=consulta&ticket=' . urlencode($created['ticket']));
    }

    public function lookup(): void
    {
        verify_csrf();
        $ticket = trim((string) ($_POST['ticket'] ?? ''));

        if ($ticket === '') {
            flash('error', 'Digite o ticket para consultar a melhoria.');
            redirect('/melhoria-publica?tab=consulta');
        }

        redirect('/melhoria-publica?tab=consulta&ticket=' . urlencode($ticket));
    }

    private function render(?array $lookup = null, bool $notFound = false, string $ticket = ''): void
    {
        $publicUrl = rtrim((string) config('app.url'), '/') . '/melhoria-publica';

        $this->view('public/melhoria', [
            'title' => 'Formulário de melhoria',
            'departments' => (new Department())->active(),
            'priorities' => $this->priorities,
            'publicUrl' => $publicUrl,
            'qrCodePath' => asset('img/qr-melhoria-publica.png'),
            'lookup' => $lookup,
            'lookupTicket' => $ticket,
            'notFound' => $notFound,
            'activeTab' => (string) ($_GET['tab'] ?? ($ticket !== '' ? 'consulta' : 'formulario')),
        ], 'layouts/public');
    }

    private function publicBackWithError(string $message): never
    {
        flash('error', $message);
        set_old($_POST);
        header('Location: ' . url('/melhoria-publica'));
        exit;
    }
}
