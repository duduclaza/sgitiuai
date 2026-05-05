<form method="post" action="<?= $improvement ? url('/melhorias/' . $improvement['id'] . '/atualizar') : url('/melhorias') ?>" class="soft-card rounded-3xl p-6">
  <?= csrf_field() ?>
  <div class="grid gap-5 lg:grid-cols-4">
    <label class="lg:col-span-4">
      <span class="mb-2 block text-sm font-bold text-slate-700">Título</span>
      <input class="form-input" name="titulo" required value="<?= e(old('titulo', $improvement['titulo'] ?? '')) ?>">
    </label>
    <label class="lg:col-span-2">
      <span class="mb-2 block text-sm font-bold text-slate-700">Departamento</span>
      <select class="form-select" name="departamento_id">
        <option value="">Selecione</option>
        <?php foreach ($departments as $department): ?><option value="<?= (int) $department['id'] ?>" <?= (int) old('departamento_id', $improvement['departamento_id'] ?? 0) === (int) $department['id'] ? 'selected' : '' ?>><?= e($department['nome']) ?></option><?php endforeach; ?>
      </select>
    </label>
    <label>
      <span class="mb-2 block text-sm font-bold text-slate-700">Prioridade</span>
      <select class="form-select" name="prioridade">
        <?php foreach ($priorities as $priority): ?><option value="<?= e($priority) ?>" <?= old('prioridade', $improvement['prioridade'] ?? 'Média') === $priority ? 'selected' : '' ?>><?= e($priority) ?></option><?php endforeach; ?>
      </select>
    </label>
    <label>
      <span class="mb-2 block text-sm font-bold text-slate-700">Status</span>
      <select class="form-select" name="status">
        <?php foreach ($statuses as $status): ?><option value="<?= e($status) ?>" <?= old('status', $improvement['status'] ?? 'Aberta') === $status ? 'selected' : '' ?>><?= e($status) ?></option><?php endforeach; ?>
      </select>
    </label>
    <label class="lg:col-span-2">
      <span class="mb-2 block text-sm font-bold text-slate-700">Responsável</span>
      <select class="form-select" name="responsavel_id">
        <option value="">Sem responsável</option>
        <?php foreach ($users as $user): ?><option value="<?= (int) $user['id'] ?>" <?= (int) old('responsavel_id', $improvement['responsavel_id'] ?? 0) === (int) $user['id'] ? 'selected' : '' ?>><?= e($user['nome']) ?></option><?php endforeach; ?>
      </select>
    </label>
    <label>
      <span class="mb-2 block text-sm font-bold text-slate-700">Prazo</span>
      <input class="form-input" type="date" name="prazo" value="<?= e(old('prazo', $improvement['prazo'] ?? '')) ?>">
    </label>
    <label>
      <span class="mb-2 block text-sm font-bold text-slate-700">Ganho estimado</span>
      <input class="form-input" type="number" step="0.01" name="ganho_estimado" value="<?= e(old('ganho_estimado', $improvement['ganho_estimado'] ?? '0')) ?>">
    </label>
    <label>
      <span class="mb-2 block text-sm font-bold text-slate-700">Data de abertura</span>
      <input class="form-input" type="date" name="data_abertura" value="<?= e(old('data_abertura', $improvement['data_abertura'] ?? date('Y-m-d'))) ?>">
    </label>
    <label>
      <span class="mb-2 block text-sm font-bold text-slate-700">Data de conclusão</span>
      <input class="form-input" type="date" name="data_conclusao" value="<?= e(old('data_conclusao', $improvement['data_conclusao'] ?? '')) ?>">
    </label>
    <label class="lg:col-span-2">
      <span class="mb-2 block text-sm font-bold text-slate-700">Descrição do problema</span>
      <textarea class="form-textarea" name="descricao_problema"><?= e(old('descricao_problema', $improvement['descricao_problema'] ?? '')) ?></textarea>
    </label>
    <label class="lg:col-span-2">
      <span class="mb-2 block text-sm font-bold text-slate-700">Melhoria sugerida</span>
      <textarea class="form-textarea" name="melhoria_sugerida"><?= e(old('melhoria_sugerida', $improvement['melhoria_sugerida'] ?? '')) ?></textarea>
    </label>
    <label class="lg:col-span-2">
      <span class="mb-2 block text-sm font-bold text-slate-700">Causa raiz</span>
      <textarea class="form-textarea" name="causa_raiz"><?= e(old('causa_raiz', $improvement['causa_raiz'] ?? '')) ?></textarea>
    </label>
    <label class="lg:col-span-2">
      <span class="mb-2 block text-sm font-bold text-slate-700">Observações</span>
      <textarea class="form-textarea" name="observacoes"><?= e(old('observacoes', $improvement['observacoes'] ?? '')) ?></textarea>
    </label>
  </div>

  <div class="mt-8 flex flex-wrap gap-3">
    <button class="btn-primary" type="submit"><i data-lucide="save" class="h-4 w-4"></i>Salvar</button>
    <a class="btn-secondary" href="<?= url('/melhorias') ?>">Cancelar</a>
    <?php if ($improvement && can('admin')): ?>
      <button form="delete-improvement" class="btn-danger" type="submit"><i data-lucide="trash-2" class="h-4 w-4"></i>Excluir</button>
    <?php endif; ?>
  </div>
</form>
<?php if ($improvement && can('admin')): ?>
<form id="delete-improvement" method="post" action="<?= url('/melhorias/' . $improvement['id'] . '/excluir') ?>" data-confirm="Excluir esta melhoria?"><?= csrf_field() ?></form>
<?php endif; ?>
