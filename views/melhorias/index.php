<?php
$statusColors = [
    'Aberta' => 'bg-sky-100 text-sky-700',
    'Em análise' => 'bg-indigo-100 text-indigo-700',
    'Aprovada' => 'bg-blue-100 text-blue-700',
    'Em implantação' => 'bg-amber-100 text-amber-700',
    'Concluída' => 'bg-emerald-100 text-emerald-700',
    'Cancelada' => 'bg-rose-100 text-rose-700',
];
$priorityColors = ['Baixa' => 'bg-slate-100 text-slate-700', 'Média' => 'bg-blue-100 text-blue-700', 'Alta' => 'bg-orange-100 text-orange-700', 'Crítica' => 'bg-red-100 text-red-700'];
?>
<div class="mb-5 flex flex-col gap-3 xl:flex-row xl:items-end xl:justify-between">
  <form method="get" class="grid flex-1 gap-3 md:grid-cols-3 xl:grid-cols-7">
    <input class="form-input md:col-span-2 xl:col-span-2" name="q" value="<?= e($filters['q']) ?>" placeholder="Buscar por ticket, título ou problema">
    <select class="form-select" name="status">
      <option value="">Todos os status</option>
      <?php foreach ($statuses as $status): ?><option value="<?= e($status) ?>" <?= $filters['status'] === $status ? 'selected' : '' ?>><?= e($status) ?></option><?php endforeach; ?>
    </select>
    <select class="form-select" name="prioridade">
      <option value="">Prioridades</option>
      <?php foreach ($priorities as $priority): ?><option value="<?= e($priority) ?>" <?= $filters['prioridade'] === $priority ? 'selected' : '' ?>><?= e($priority) ?></option><?php endforeach; ?>
    </select>
    <select class="form-select" name="departamento_id">
      <option value="">Departamentos</option>
      <?php foreach ($departments as $department): ?><option value="<?= (int) $department['id'] ?>" <?= (string) $filters['departamento_id'] === (string) $department['id'] ? 'selected' : '' ?>><?= e($department['nome']) ?></option><?php endforeach; ?>
    </select>
    <input class="form-input" name="responsavel_nome" value="<?= e($filters['responsavel_nome']) ?>" placeholder="Responsável">
    <button class="btn-secondary" type="submit"><i data-lucide="search" class="h-4 w-4"></i>Filtrar</button>
  </form>
  <?php if (can(['admin', 'usuario'], 'criar_melhoria')): ?>
    <div class="flex flex-wrap gap-2">
      <a href="<?= url('/melhoria-publica') ?>" class="btn-secondary" target="_blank" rel="noopener"><i data-lucide="qr-code" class="h-4 w-4"></i>Link público</a>
      <a href="<?= url('/melhorias/nova') ?>" class="btn-primary"><i data-lucide="plus" class="h-4 w-4"></i>Nova melhoria</a>
    </div>
  <?php endif; ?>
</div>

<section class="soft-card overflow-hidden rounded-3xl">
  <div class="table-wrap">
    <table class="data-table">
      <thead>
      <tr>
        <th>Ticket</th>
        <th>Título</th>
        <th>Departamento</th>
        <th>Status</th>
        <th>Prioridade</th>
        <th>Responsável</th>
        <th class="text-right">Ações</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($improvements as $improvement): ?>
        <tr>
          <td>
            <span class="font-black text-slate-900"><?= e($improvement['ticket'] ?? '-') ?></span>
          </td>
          <td>
            <a href="<?= url('/melhorias/' . $improvement['id']) ?>" class="font-black text-slate-950 hover:text-blue-700"><?= e($improvement['titulo']) ?></a>
            <p class="mt-1 line-clamp-1 text-sm text-slate-500"><?= e($improvement['descricao_problema'] ?? '') ?></p>
          </td>
          <td><?= e($improvement['departamento_nome'] ?? '-') ?></td>
          <td><span class="badge <?= $statusColors[$improvement['status']] ?? 'bg-slate-100 text-slate-700' ?>"><?= e($improvement['status']) ?></span></td>
          <td><span class="badge <?= $priorityColors[$improvement['prioridade']] ?? 'bg-slate-100 text-slate-700' ?>"><?= e($improvement['prioridade']) ?></span></td>
          <td><?= e($improvement['responsavel_nome'] ?? '-') ?></td>
          <td>
            <div class="flex justify-end gap-2">
              <a class="btn-secondary !p-2.5" href="<?= url('/melhorias/' . $improvement['id']) ?>" title="Ver"><i data-lucide="eye" class="h-4 w-4"></i></a>
              <?php if (can('admin')): ?>
                <a class="btn-secondary !p-2.5" href="<?= url('/melhorias/' . $improvement['id'] . '/editar') ?>" title="Editar"><i data-lucide="pencil" class="h-4 w-4"></i></a>
              <?php endif; ?>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$improvements): ?><tr><td colspan="7" class="text-center text-slate-500">Nenhuma melhoria encontrada.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</section>
