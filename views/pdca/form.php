<?php $stages = ['plan' => 'Plan', 'do' => 'Do', 'check' => 'Check', 'act' => 'Act']; ?>
<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
  <div>
    <p class="text-sm font-bold text-slate-500">Ticket <?= e($improvement['ticket'] ?? ('#' . (int) $improvement['id'])) ?></p>
    <h2 class="text-2xl font-black text-slate-950"><?= e($improvement['titulo']) ?></h2>
  </div>
  <a class="btn-secondary" href="<?= url('/melhorias/' . $improvement['id']) ?>"><i data-lucide="arrow-left" class="h-4 w-4"></i>Voltar</a>
</div>
<form method="post" action="<?= url('/pdca/' . $improvement['id']) ?>" class="grid gap-5">
  <?= csrf_field() ?>
  <?php foreach ($stages as $key => $label): ?>
    <section class="soft-card rounded-3xl p-6">
      <h3 class="text-lg font-black text-slate-950"><?= e($label) ?></h3>
      <div class="mt-4 grid gap-4 lg:grid-cols-4">
        <label class="lg:col-span-4">
          <span class="mb-2 block text-sm font-bold text-slate-700">Descrição</span>
          <textarea class="form-textarea" name="<?= $key ?>_text"><?= e($pdca[$key . '_text'] ?? '') ?></textarea>
        </label>
        <label>
          <span class="mb-2 block text-sm font-bold text-slate-700">Status</span>
          <select class="form-select" name="<?= $key ?>_status">
            <?php foreach ($stageStatuses as $status): ?><option value="<?= e($status) ?>" <?= ($pdca[$key . '_status'] ?? 'Pendente') === $status ? 'selected' : '' ?>><?= e($status) ?></option><?php endforeach; ?>
          </select>
        </label>
        <label class="lg:col-span-2">
          <span class="mb-2 block text-sm font-bold text-slate-700">Responsável</span>
          <select class="form-select" name="<?= $key ?>_responsavel_id">
            <option value="">Sem responsável</option>
            <?php foreach ($users as $user): ?><option value="<?= (int) $user['id'] ?>" <?= (int) ($pdca[$key . '_responsavel_id'] ?? 0) === (int) $user['id'] ? 'selected' : '' ?>><?= e($user['nome']) ?></option><?php endforeach; ?>
          </select>
        </label>
        <label>
          <span class="mb-2 block text-sm font-bold text-slate-700">Prazo</span>
          <input class="form-input" type="date" name="<?= $key ?>_prazo" value="<?= e($pdca[$key . '_prazo'] ?? '') ?>">
        </label>
      </div>
    </section>
  <?php endforeach; ?>
  <div class="flex flex-wrap gap-3">
    <button class="btn-primary" type="submit"><i data-lucide="save" class="h-4 w-4"></i>Salvar PDCA</button>
    <a href="<?= url('/pdca') ?>" class="btn-secondary">Cancelar</a>
  </div>
</form>
