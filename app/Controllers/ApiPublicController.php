<?php

namespace App\Controllers;

use App\Models\Department;
use App\Models\Improvement;

class ApiPublicController extends Controller
{
    public function store()
    {
        if ($this->method() !== 'POST') {
            return $this->json(['error' => 'Método não permitido'], 405);
        }

        $data = $this->request();
        
        $titulo = trim($data['titulo'] ?? '');
        $responsavel_nome = trim($data['responsavel_nome'] ?? '');
        $descricao_problema = trim($data['descricao_problema'] ?? '');

        if (empty($titulo) || empty($responsavel_nome) || empty($descricao_problema)) {
            return $this->json(['error' => 'Campos obrigatórios não preenchidos'], 422);
        }

        try {
            $improvement = new Improvement();
            $improvement->insert([
                'titulo' => $titulo,
                'departamento_id' => (int) ($data['departamento_id'] ?? 0),
                'responsavel_nome' => $responsavel_nome,
                'prioridade' => $data['prioridade'] ?? 'Média',
                'descricao_problema' => $descricao_problema,
                'melhoria_sugerida' => $data['melhoria_sugerida'] ?? '',
                'causa_raiz' => $data['causa_raiz'] ?? '',
                'observacoes' => $data['observacoes'] ?? '',
                'status' => 'Aberta',
                'criado_em' => date('Y-m-d H:i:s'),
            ]);

            return $this->json(['message' => 'Melhoria registrada com sucesso'], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Erro ao registrar melhoria'], 500);
        }
    }

    public function getDepartments()
    {
        try {
            $departments = (new Department())->all();
            return $this->json(['data' => $departments]);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Erro ao carregar departamentos'], 500);
        }
    }

    public function lookup()
    {
        if ($this->method() !== 'POST') {
            return $this->json(['error' => 'Método não permitido'], 405);
        }

        $data = $this->request();
        $ticket = trim($data['ticket'] ?? '');

        if (empty($ticket)) {
            return $this->json(['error' => 'Ticket é obrigatório'], 422);
        }

        try {
            $improvement = (new Improvement())->findByTicket($ticket);
            if (!$improvement) {
                return $this->json(['error' => 'Ticket não encontrado'], 404);
            }

            return $this->json(['data' => $improvement]);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Erro ao buscar ticket'], 500);
        }
    }

    protected function json(array $data, int $statusCode = 200): string
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        return json_encode($data);
    }

    protected function method(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    protected function request(): array
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        return is_array($data) ? $data : [];
    }
}
