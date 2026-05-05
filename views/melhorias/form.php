<?php
$responsavelAtual = old('responsavel_nome', $improvement['responsavel_nome'] ?? '');
$isEditing = (bool) $improvement;
?>
<form method="post" action="<?= $improvement ? url('/melhorias/' . $improvement['id'] . '/atualizar') : url('/melhorias') ?>" class="space-y-6">
  <?= csrf_field() ?>

  <section class="soft-card rounded-3xl p-5 sm:p-6">
    <div class="mb-5 flex flex-col gap-1">
      <p class="text-xs font-black uppercase tracking-normal text-blue-600">Identificação</p>
      <h2 class="text-lg font-black text-slate-950">Dados principais da melhoria</h2>
      <p class="text-sm text-slate-500">Comece pelo problema, a área envolvida e quem está registrando a melhoria.</p>
    </div>

    <div class="grid gap-5 lg:grid-cols-12">
      <?php if ($isEditing): ?>
        <div class="lg:col-span-12 rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3">
          <span class="block text-xs font-black uppercase tracking-normal text-blue-600">Ticket de acompanhamento</span>
          <strong class="mt-1 block text-lg font-black text-slate-950"><?= e($improvement['ticket'] ?? 'Ticket pendente') ?></strong>
        </div>
      <?php endif; ?>

      <label class="lg:col-span-12">
        <span class="mb-2 block text-sm font-bold text-slate-700">Título</span>
        <input class="form-input" name="titulo" required value="<?= e(old('titulo', $improvement['titulo'] ?? '')) ?>" placeholder="Ex.: Reduzir retrabalho na conferência de pedidos">
      </label>

      <label class="lg:col-span-4">
        <span class="mb-2 block text-sm font-bold text-slate-700">Departamento</span>
        <select class="form-select" name="departamento_id">
          <option value="">Selecione</option>
          <?php foreach ($departments as $department): ?>
            <option value="<?= (int) $department['id'] ?>" <?= (int) old('departamento_id', $improvement['departamento_id'] ?? 0) === (int) $department['id'] ? 'selected' : '' ?>><?= e($department['nome']) ?></option>
          <?php endforeach; ?>
        </select>
      </label>

      <label class="<?= $isEditing ? 'lg:col-span-3' : 'lg:col-span-4' ?>">
        <span class="mb-2 block text-sm font-bold text-slate-700">Seu nome</span>
        <input class="form-input" name="responsavel_nome" value="<?= e($responsavelAtual) ?>" placeholder="Seu nome">
      </label>

      <label class="lg:col-span-2">
        <span class="mb-2 block text-sm font-bold text-slate-700">Prioridade</span>
        <select class="form-select" name="prioridade">
          <?php foreach ($priorities as $priority): ?>
            <option value="<?= e($priority) ?>" <?= old('prioridade', $improvement['prioridade'] ?? 'Média') === $priority ? 'selected' : '' ?>><?= e($priority) ?></option>
          <?php endforeach; ?>
        </select>
      </label>

      <?php if ($isEditing): ?>
        <label class="lg:col-span-3">
          <span class="mb-2 block text-sm font-bold text-slate-700">Status</span>
          <select class="form-select" name="status">
            <?php foreach ($statuses as $status): ?>
              <option value="<?= e($status) ?>" <?= old('status', $improvement['status'] ?? 'Aberta') === $status ? 'selected' : '' ?>><?= e($status) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
      <?php else: ?>
        <div class="lg:col-span-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
          <span class="block text-sm font-bold text-slate-700">Status inicial</span>
          <strong class="mt-1 inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-black text-sky-700">Aberta</strong>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <section class="soft-card rounded-3xl p-5 sm:p-6">
    <div class="mb-5 flex flex-col gap-1">
      <p class="text-xs font-black uppercase tracking-normal text-blue-600">Planejamento</p>
      <h2 class="text-lg font-black text-slate-950">Data de abertura</h2>
      <p class="text-sm text-slate-500">A captação registra apenas o momento da abertura. Prazo, conclusão e ganhos entram depois na evolução da análise.</p>
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
      <label class="sm:col-span-1">
        <span class="mb-2 block text-sm font-bold text-slate-700">Data de abertura</span>
        <input class="form-input" type="date" name="data_abertura" value="<?= e(old('data_abertura', $improvement['data_abertura'] ?? date('Y-m-d'))) ?>">
      </label>
    </div>
  </section>

  <section class="soft-card rounded-3xl p-5 sm:p-6">
    <div class="mb-5 flex flex-col gap-1">
      <p class="text-xs font-black uppercase tracking-normal text-blue-600">Análise</p>
      <h2 class="text-lg font-black text-slate-950">Problema, proposta e causa raiz</h2>
      <p class="text-sm text-slate-500">Campos maiores ficam juntos para facilitar a escrita e comparação das informações.</p>
    </div>

    <div class="grid gap-5 xl:grid-cols-2">
      <label>
        <span class="mb-2 block text-sm font-bold text-slate-700">Descrição do problema</span>
        <textarea class="form-textarea min-h-40" name="descricao_problema" placeholder="O que está acontecendo, onde ocorre e qual o impacto?"><?= e(old('descricao_problema', $improvement['descricao_problema'] ?? '')) ?></textarea>
      </label>

      <label>
        <span class="mb-2 block text-sm font-bold text-slate-700">Melhoria sugerida</span>
        <textarea class="form-textarea min-h-40" name="melhoria_sugerida" placeholder="Qual mudança pode resolver ou reduzir o problema?"><?= e(old('melhoria_sugerida', $improvement['melhoria_sugerida'] ?? '')) ?></textarea>
      </label>

      <label>
        <span class="mb-2 block text-sm font-bold text-slate-700">Causa raiz</span>
        <textarea class="form-textarea" name="causa_raiz" placeholder="Se já souber, registre a causa provável ou validada."><?= e(old('causa_raiz', $improvement['causa_raiz'] ?? '')) ?></textarea>
      </label>

      <label>
        <span class="mb-2 block text-sm font-bold text-slate-700">Observações</span>
        <textarea class="form-textarea" name="observacoes" placeholder="Inclua contexto, restrições, evidências ou próximos cuidados."><?= e(old('observacoes', $improvement['observacoes'] ?? '')) ?></textarea>
      </label>
    </div>
  </section>

  <div class="form-actions flex flex-wrap gap-3 rounded-3xl border border-slate-200 bg-white/85 p-4 shadow-lg shadow-slate-200/70 backdrop-blur-xl">
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
