<?php
$statusColors = [
    'Aberta' => 'bg-sky-100 text-sky-700',
    'Em análise' => 'bg-indigo-100 text-indigo-700',
    'Aprovada' => 'bg-blue-100 text-blue-700',
    'Em implantação' => 'bg-amber-100 text-amber-700',
    'Concluída' => 'bg-emerald-100 text-emerald-700',
    'Cancelada' => 'bg-rose-100 text-rose-700',
];
?>
<section class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
  <?php foreach ([
      ['label' => 'Total de melhorias', 'value' => $stats['total'], 'icon' => 'sparkles'],
      ['label' => 'Atrasadas', 'value' => $stats['late'], 'icon' => 'timer'],
      ['label' => 'Concluídas', 'value' => $stats['done'], 'icon' => 'circle-check'],
      ['label' => 'Em implantação', 'value' => $stats['implantation'], 'icon' => 'rocket'],
      ['label' => 'Ganho estimado', 'value' => money_br($stats['gain']), 'icon' => 'trending-up'],
  ] as $card): ?>
    <article class="soft-card rounded-3xl p-5">
      <div class="flex items-center justify-between gap-4">
        <p class="text-sm font-bold text-slate-500"><?= e($card['label']) ?></p>
        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-blue-50 text-blue-600"><i data-lucide="<?= e($card['icon']) ?>" class="h-5 w-5"></i></span>
      </div>
      <p class="mt-4 text-3xl font-black text-slate-950"><?= e((string) $card['value']) ?></p>
    </article>
  <?php endforeach; ?>
</section>

<section class="mt-6 grid gap-6 xl:grid-cols-[1.2fr_.8fr]">
  <article class="soft-card rounded-3xl p-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-lg font-black text-slate-950">Evolução mensal</h2>
        <p class="text-sm text-slate-500">Aberturas de melhoria por mês</p>
      </div>
      <i data-lucide="bar-chart-3" class="h-6 w-6 text-blue-600"></i>
    </div>
    <canvas class="mt-5 h-72 w-full" data-chart='<?= e(json_encode($stats['monthly'], JSON_UNESCAPED_UNICODE)) ?>'></canvas>
  </article>

  <article class="soft-card rounded-3xl p-6">
    <h2 class="text-lg font-black text-slate-950">Melhorias por status</h2>
    <div class="mt-5 space-y-3">
      <?php foreach ($stats['byStatus'] as $row): ?>
        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
          <span class="badge <?= $statusColors[$row['status']] ?? 'bg-slate-100 text-slate-700' ?>"><?= e($row['status']) ?></span>
          <span class="text-xl font-black text-slate-900"><?= (int) $row['total'] ?></span>
        </div>
      <?php endforeach; ?>
      <?php if (!$stats['byStatus']): ?>
        <p class="rounded-2xl bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">Nenhuma melhoria cadastrada ainda.</p>
      <?php endif; ?>
    </div>
  </article>
</section>

<section class="mt-6 grid gap-6 xl:grid-cols-2">
  <article class="soft-card rounded-3xl p-6">
    <h2 class="text-lg font-black text-slate-950">Ranking de departamentos</h2>
    <div class="mt-5 space-y-3">
      <?php foreach ($stats['byDepartment'] as $row): ?>
        <div>
          <div class="mb-1 flex justify-between text-sm font-bold text-slate-600">
            <span><?= e($row['nome']) ?></span>
            <span><?= (int) $row['total'] ?></span>
          </div>
          <div class="h-3 overflow-hidden rounded-full bg-slate-100">
            <div class="h-full rounded-full bg-blue-500" style="width: <?= min(100, ((int) $row['total'] / max(1, (int) $stats['total'])) * 100) ?>%"></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </article>

  <article class="soft-card rounded-3xl p-6">
    <h2 class="text-lg font-black text-slate-950">Equipe ativa</h2>
    <div class="mt-5 grid gap-3 sm:grid-cols-2">
      <?php foreach (array_slice($users, 0, 6) as $member): ?>
        <div class="rounded-2xl bg-slate-50 p-4">
          <p class="font-black text-slate-900"><?= e($member['nome']) ?></p>
          <p class="text-sm text-slate-500"><?= e($member['perfil']) ?> · <?= e($member['status']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </article>
</section>
