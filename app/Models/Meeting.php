<?php

namespace App\Models;

use App\Core\Model;

class Meeting extends Model
{
    protected string $table = 'reunioes';
    protected array $fillable = ['tema', 'data', 'horario', 'participantes', 'melhorias_discutidas', 'decisoes', 'proximas_acoes', 'ata_resumo', 'criado_por'];

    public function list(array $filters = []): array
    {
        $sql = 'SELECT r.*, u.nome AS criador_nome FROM reunioes r LEFT JOIN usuarios u ON u.id = r.criado_por WHERE 1=1';
        $params = [];

        if (!empty($filters['q'])) {
            $sql .= ' AND (r.tema LIKE :q OR r.participantes LIKE :q)';
            $params['q'] = '%' . $filters['q'] . '%';
        }

        $sql .= ' ORDER BY r.data DESC, r.horario DESC';
        $statement = $this->db()->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll();
    }
}
