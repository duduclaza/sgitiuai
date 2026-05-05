<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Department;
use App\Models\Improvement;
use App\Services\AuditLogger;
use App\Services\NotificationService;

class ImprovementController extends Controller
{
    public array $statuses = ['Aberta', 'Em análise', 'Aprovada', 'Em implantação', 'Concluída', 'Cancelada'];
    public array $priorities = ['Baixa', 'Média', 'Alta', 'Crítica'];

    public function index(): void
    {
        $filters = [
            'q' => $_GET['q'] ?? '',
            'status' => $_GET['status'] ?? '',
            'prioridade' => $_GET['prioridade'] ?? '',
            'departamento_id' => $_GET['departamento_id'] ?? '',
            'responsavel_nome' => $_GET['responsavel_nome'] ?? '',
        ];

        $this->view('melhorias/index', [
            'title' => 'Melhorias',
            'improvements' => (new Improvement())->list($filters),
            'departments' => (new Department())->active(),
            'filters' => $filters,
            'statuses' => $this->statuses,
            'priorities' => $this->priorities,
        ]);
    }

    public function create(): void
    {
        if (!Auth::can(['admin', 'usuario'], 'criar_melhoria')) {
            http_response_code(403);
            require base_path('views/errors/403.php');
            return;
        }

        $this->view('melhorias/form', $this->formData('Nova melhoria'));
    }

    public function store(): void
    {
        verify_csrf();
        if (!Auth::can(['admin', 'usuario'], 'criar_melhoria')) {
            $this->backWithError('Você não tem permissão para cadastrar melhorias.');
        }

        $data = $this->payload();
        $data['criado_por'] = Auth::id();
        $data['data_abertura'] = $data['data_abertura'] ?: date('Y-m-d');
        $id = (new Improvement())->create($data);

        AuditLogger::log('criação', 'melhorias', $id, ['titulo' => $data['titulo']]);

        flash('success', 'Melhoria cadastrada.');
        redirect('/melhorias/' . $id);
    }

    public function show(string $id): void
    {
        $improvement = (new Improvement())->findWithRelations((int) $id);
        if (!$improvement) {
            flash('error', 'Melhoria não encontrada.');
            redirect('/melhorias');
        }

        $this->view('melhorias/show', [
            'title' => $improvement['titulo'],
            'improvement' => $improvement,
            'comments' => (new Comment())->byImprovement((int) $id),
            'attachments' => (new Attachment())->byImprovement((int) $id),
        ]);
    }

    public function edit(string $id): void
    {
        $improvement = (new Improvement())->find((int) $id);
        if (!$improvement) {
            flash('error', 'Melhoria não encontrada.');
            redirect('/melhorias');
        }

        $this->view('melhorias/form', $this->formData('Editar melhoria', $improvement));
    }

    public function update(string $id): void
    {
        verify_csrf();
        $model = new Improvement();
        $before = $model->find((int) $id);
        $data = $this->payload();
        $model->update((int) $id, $data);

        AuditLogger::log('edição', 'melhorias', (int) $id, ['status' => $data['status']]);
        if ($before && $before['status'] !== $data['status'] && !empty($before['criado_por'])) {
            (new NotificationService())->create((int) $before['criado_por'], 'Status atualizado', "{$before['titulo']} agora está como {$data['status']}", 'status', '/melhorias/' . $id);
        }

        flash('success', 'Melhoria atualizada.');
        redirect('/melhorias/' . $id);
    }

    public function destroy(string $id): void
    {
        verify_csrf();
        (new Improvement())->delete((int) $id);
        AuditLogger::log('exclusão', 'melhorias', (int) $id);
        flash('success', 'Melhoria removida.');
        redirect('/melhorias');
    }

    private function formData(string $title, ?array $improvement = null): array
    {
        return [
            'title' => $title,
            'improvement' => $improvement,
            'departments' => (new Department())->active(),
            'statuses' => $this->statuses,
            'priorities' => $this->priorities,
        ];
    }

    private function payload(): array
    {
        $title = trim((string) ($_POST['titulo'] ?? ''));
        if ($title === '') {
            $this->backWithError('O título da melhoria é obrigatório.');
        }

        return [
            'titulo' => $title,
            'departamento_id' => $_POST['departamento_id'] !== '' ? (int) $_POST['departamento_id'] : null,
            'descricao_problema' => trim((string) ($_POST['descricao_problema'] ?? '')),
            'melhoria_sugerida' => trim((string) ($_POST['melhoria_sugerida'] ?? '')),
            'prioridade' => (string) ($_POST['prioridade'] ?? 'Média'),
            'status' => (string) ($_POST['status'] ?? 'Aberta'),
            'responsavel_id' => null,
            'responsavel_nome' => trim((string) ($_POST['responsavel_nome'] ?? '')),
            'prazo' => ($_POST['prazo'] ?? '') !== '' ? $_POST['prazo'] : null,
            'ganho_estimado' => (float) str_replace(',', '.', (string) ($_POST['ganho_estimado'] ?? 0)),
            'data_abertura' => ($_POST['data_abertura'] ?? '') !== '' ? $_POST['data_abertura'] : null,
            'data_conclusao' => ($_POST['data_conclusao'] ?? '') !== '' ? $_POST['data_conclusao'] : null,
            'causa_raiz' => trim((string) ($_POST['causa_raiz'] ?? '')),
            'observacoes' => trim((string) ($_POST['observacoes'] ?? '')),
        ];
    }
}
