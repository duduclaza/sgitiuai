<?php
$statusColors = ['Aberta' => 'bg-sky-100 text-sky-700', 'Em análise' => 'bg-indigo-100 text-indigo-700', 'Aprovada' => 'bg-blue-100 text-blue-700', 'Em implantação' => 'bg-amber-100 text-amber-700', 'Concluída' => 'bg-emerald-100 text-emerald-700', 'Cancelada' => 'bg-rose-100 text-rose-700'];
?>
<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
  <div>
    <p class="text-sm font-bold text-slate-500">Ticket <?= e($improvement['ticket'] ?? ('#' . (int) $improvement['id'])) ?></p>
    <h2 class="text-2xl font-black text-slate-950"><?= e($improvement['titulo']) ?></h2>
  </div>
  <div class="flex flex-wrap gap-2">
    <?php if (can('admin')): ?>
      <a href="<?= url('/pdca/' . $improvement['id'] . '/editar') ?>" class="btn-secondary"><i data-lucide="refresh-cw" class="h-4 w-4"></i>PDCA</a>
      <a href="<?= url('/swot/' . $improvement['id'] . '/editar') ?>" class="btn-secondary"><i data-lucide="grid-2x2" class="h-4 w-4"></i>SWOT</a>
      <a href="<?= url('/5w2h/' . $improvement['id'] . '/editar') ?>" class="btn-secondary"><i data-lucide="list-checks" class="h-4 w-4"></i>5W2H</a>
      <a href="<?= url('/melhorias/' . $improvement['id'] . '/editar') ?>" class="btn-primary"><i data-lucide="pencil" class="h-4 w-4"></i>Editar</a>
    <?php endif; ?>
  </div>
</div>

<section class="grid gap-6 xl:grid-cols-[1.15fr_.85fr]">
  <article class="soft-card rounded-3xl p-6">
    <div class="flex flex-wrap gap-2">
      <span class="badge <?= $statusColors[$improvement['status']] ?? 'bg-slate-100 text-slate-700' ?>"><?= e($improvement['status']) ?></span>
      <span class="badge bg-blue-100 text-blue-700"><?= e($improvement['prioridade']) ?></span>
      <span class="badge bg-slate-100 text-slate-700"><?= e($improvement['departamento_nome'] ?? 'Sem departamento') ?></span>
    </div>

    <div class="mt-6 grid gap-5 md:grid-cols-2">
      <div>
        <p class="text-sm font-bold text-slate-500">Problema</p>
        <p class="mt-1 whitespace-pre-wrap text-slate-800"><?= e($improvement['descricao_problema']) ?></p>
      </div>
      <div>
        <p class="text-sm font-bold text-slate-500">Melhoria sugerida</p>
        <p class="mt-1 whitespace-pre-wrap text-slate-800"><?= e($improvement['melhoria_sugerida']) ?></p>
      </div>
      <div>
        <p class="text-sm font-bold text-slate-500">Causa raiz</p>
        <p class="mt-1 whitespace-pre-wrap text-slate-800"><?= e($improvement['causa_raiz']) ?></p>
      </div>
      <div>
        <p class="text-sm font-bold text-slate-500">Observações</p>
        <p class="mt-1 whitespace-pre-wrap text-slate-800"><?= e($improvement['observacoes']) ?></p>
      </div>
    </div>
  </article>

  <aside class="space-y-6">
    <article class="soft-card rounded-3xl p-6">
      <h3 class="font-black text-slate-950">Acompanhamento</h3>
      <dl class="mt-4 space-y-3 text-sm">
        <div class="flex justify-between gap-4"><dt class="text-slate-500">Responsável</dt><dd class="font-bold text-slate-800"><?= e($improvement['responsavel_nome'] ?? '-') ?></dd></div>
        <div class="flex justify-between gap-4"><dt class="text-slate-500">Ticket</dt><dd class="font-bold text-slate-800"><?= e($improvement['ticket'] ?? '-') ?></dd></div>
        <div class="flex justify-between gap-4"><dt class="text-slate-500">Abertura</dt><dd class="font-bold text-slate-800"><?= date_br($improvement['data_abertura']) ?></dd></div>
      </dl>
    </article>

    <article class="soft-card rounded-3xl p-6">
      <h3 class="font-black text-slate-950">Anexos</h3>
      <?php if (can(['admin', 'usuario'], 'anexar')): ?>
        <form method="post" action="<?= url('/melhorias/' . $improvement['id'] . '/anexos') ?>" enctype="multipart/form-data" class="mt-4 flex flex-col gap-2 sm:flex-row">
          <?= csrf_field() ?>
          <input class="form-input" type="file" name="arquivo" required>
          <button class="btn-secondary !px-3" title="Anexar"><i data-lucide="paperclip" class="h-4 w-4"></i></button>
        </form>
      <?php endif; ?>
      <div class="mt-4 space-y-2">
        <?php foreach ($attachments as $attachment): ?>
          <div class="flex items-center justify-between gap-3 rounded-2xl bg-slate-50 px-3 py-2">
            <a class="truncate text-sm font-bold text-blue-700" href="<?= url('/anexos/' . $attachment['id'] . '/baixar') ?>"><?= e($attachment['nome_original']) ?></a>
            <?php if (can('admin')): ?>
              <form method="post" action="<?= url('/anexos/' . $attachment['id'] . '/excluir') ?>" data-confirm="Excluir anexo?"><?= csrf_field() ?><button class="text-red-600"><i data-lucide="trash-2" class="h-4 w-4"></i></button></form>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
        <?php if (!$attachments): ?><p class="text-sm text-slate-500">Nenhum anexo.</p><?php endif; ?>
      </div>
    </article>
  </aside>
</section>

<section class="soft-card mt-6 rounded-3xl p-6">
  <h3 class="font-black text-slate-950">Comentários</h3>
  <?php if (can(['admin', 'usuario'], 'comentar')): ?>
    <form method="post" action="<?= url('/melhorias/' . $improvement['id'] . '/comentarios') ?>" class="mt-4">
      <?= csrf_field() ?>
      <textarea class="form-textarea" name="comentario" required placeholder="Registre uma atualização, decisão ou dúvida"></textarea>
      <button class="btn-primary mt-3" type="submit"><i data-lucide="send" class="h-4 w-4"></i>Comentar</button>
    </form>
  <?php endif; ?>
  <div class="mt-6 space-y-3">
    <?php foreach ($comments as $comment): ?>
      <div class="rounded-2xl bg-slate-50 p-4">
        <div class="flex justify-between gap-3">
          <p class="font-black text-slate-900"><?= e($comment['autor_nome']) ?></p>
          <span class="text-xs font-bold text-slate-500"><?= datetime_br($comment['created_at']) ?></span>
        </div>
        <p class="mt-2 whitespace-pre-wrap text-slate-700"><?= e($comment['comentario']) ?></p>
      </div>
    <?php endforeach; ?>
    <?php if (!$comments): ?><p class="text-sm text-slate-500">Nenhum comentário registrado.</p><?php endif; ?>
  </div>
</section>
