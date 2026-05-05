<?php

namespace App\Models;

use App\Core\Model;

class Improvement extends Model
{
    protected string $table = 'melhorias';
    protected array $fillable = [
        'titulo',
        'departamento_id',
        'descricao_problema',
        'melhoria_sugerida',
        'prioridade',
        'status',
        'responsavel_id',
        'responsavel_nome',
        'prazo',
        'ganho_estimado',
        'data_abertura',
        'data_conclusao',
        'causa_raiz',
        'observacoes',
        'criado_por',
    ];

    public function list(array $filters = []): array
    {
        [$where, $params] = $this->buildFilters($filters);
        $sql = "SELECT m.*, d.nome AS departamento_nome, COALESCE(NULLIF(m.responsavel_nome, ''), u.nome) AS responsavel_nome, c.nome AS criador_nome
                FROM melhorias m
                LEFT JOIN departamentos d ON d.id = m.departamento_id
                LEFT JOIN usuarios u ON u.id = m.responsavel_id
                LEFT JOIN usuarios c ON c.id = m.criado_por
                {$where}
                ORDER BY m.created_at DESC";

        $statement = $this->db()->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll();
    }

    public function findWithRelations(int $id): ?array
    {
        $statement = $this->db()->prepare(
            "SELECT m.*, d.nome AS departamento_nome, COALESCE(NULLIF(m.responsavel_nome, ''), u.nome) AS responsavel_nome, c.nome AS criador_nome
             FROM melhorias m
             LEFT JOIN departamentos d ON d.id = m.departamento_id
             LEFT JOIN usuarios u ON u.id = m.responsavel_id
             LEFT JOIN usuarios c ON c.id = m.criado_por
             WHERE m.id = :id LIMIT 1"
        );
        $statement->execute(['id' => $id]);
        $item = $statement->fetch();
        return $item ?: null;
    }

    public function dashboardStats(): array
    {
        $db = $this->db();
        $total = (int) $db->query('SELECT COUNT(*) FROM melhorias')->fetchColumn();
        $open = (int) $db->query("SELECT COUNT(*) FROM melhorias WHERE status = 'Aberta'")->fetchColumn();
        $done = (int) $db->query("SELECT COUNT(*) FROM melhorias WHERE status = 'Concluída'")->fetchColumn();
        $implantation = (int) $db->query("SELECT COUNT(*) FROM melhorias WHERE status = 'Em implantação'")->fetchColumn();
        $gain = (float) $db->query("SELECT COALESCE(SUM(ganho_estimado), 0) FROM melhorias WHERE status <> 'Cancelada'")->fetchColumn();

        $byStatus = $db->query('SELECT status, COUNT(*) total FROM melhorias GROUP BY status ORDER BY total DESC')->fetchAll();
        $byDepartment = $db->query('SELECT d.nome, COUNT(m.id) total FROM departamentos d LEFT JOIN melhorias m ON m.departamento_id = d.id GROUP BY d.id, d.nome ORDER BY total DESC LIMIT 8')->fetchAll();
        $monthly = $db->query("SELECT DATE_FORMAT(data_abertura, '%Y-%m') mes, COUNT(*) total FROM melhorias GROUP BY mes ORDER BY mes ASC LIMIT 12")->fetchAll();

        return compact('total', 'open', 'done', 'implantation', 'gain', 'byStatus', 'byDepartment', 'monthly');
    }

    public function report(array $filters = []): array
    {
        return $this->list($filters);
    }

    private function buildFilters(array $filters): array
    {
        $sql = 'WHERE 1=1';
        $params = [];

        if (!empty($filters['q'])) {
            $sql .= ' AND (m.titulo LIKE :q OR m.descricao_problema LIKE :q OR m.melhoria_sugerida LIKE :q)';
            $params['q'] = '%' . $filters['q'] . '%';
        }

        foreach (['status', 'prioridade'] as $field) {
            if (!empty($filters[$field])) {
                $sql .= " AND m.{$field} = :{$field}";
                $params[$field] = $filters[$field];
            }
        }

        if (!empty($filters['departamento_id'])) {
            $sql .= ' AND m.departamento_id = :departamento_id';
            $params['departamento_id'] = $filters['departamento_id'];
        }

        if (!empty($filters['responsavel_id'])) {
            $sql .= ' AND m.responsavel_id = :responsavel_id';
            $params['responsavel_id'] = $filters['responsavel_id'];
        }

        if (!empty($filters['responsavel_nome'])) {
            $sql .= ' AND (m.responsavel_nome LIKE :responsavel_nome OR u.nome LIKE :responsavel_nome)';
            $params['responsavel_nome'] = '%' . $filters['responsavel_nome'] . '%';
        }

        if (!empty($filters['inicio'])) {
            $sql .= ' AND m.data_abertura >= :inicio';
            $params['inicio'] = $filters['inicio'];
        }

        if (!empty($filters['fim'])) {
            $sql .= ' AND m.data_abertura <= :fim';
            $params['fim'] = $filters['fim'];
        }

        return [$sql, $params];
    }
}
