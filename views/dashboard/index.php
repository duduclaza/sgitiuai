<?php
$statusColors = [
    'Aberta' => 'bg-sky-50 text-sky-700 ring-sky-200',
    'Em análise' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
    'Aprovada' => 'bg-blue-50 text-blue-700 ring-blue-200',
    'Em implantação' => 'bg-amber-50 text-amber-700 ring-amber-200',
    'Concluída' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
    'Cancelada' => 'bg-rose-50 text-rose-700 ring-rose-200',
];
$completionRate = $stats['total'] > 0 ? round(($stats['done'] / $stats['total']) * 100) : 0;
$implantationRate = $stats['total'] > 0 ? round(($stats['implantation'] / $stats['total']) * 100) : 0;
$cards = [
    ['label' => 'Total de melhorias', 'value' => $stats['total'], 'icon' => 'sparkles', 'tone' => 'blue'],
    ['label' => 'Abertas', 'value' => $stats['open'], 'icon' => 'folder-open', 'tone' => 'sky'],
    ['label' => 'Concluídas', 'value' => $stats['done'], 'icon' => 'circle-check', 'tone' => 'emerald'],
    ['label' => 'Em implantação', 'value' => $stats['implantation'], 'icon' => 'rocket', 'tone' => 'amber'],
    ['label' => 'Ganho estimado', 'value' => money_br($stats['gain']), 'icon' => 'trending-up', 'tone' => 'slate'],
];
?>

<section class="dashboard-hero rounded-[1.75rem] border border-slate-200/80 bg-white/90 p-5 shadow-sm shadow-slate-200/70 backdrop-blur-xl sm:p-6">
  <div class="grid gap-6 xl:grid-cols-[1fr_340px] xl:items-end">
    <div>
      <p class="text-xs font-black uppercase tracking-normal text-blue-600">Visão executiva</p>
      <h2 class="mt-2 text-2xl font-black text-slate-950 sm:text-3xl">Melhorias contínuas em andamento</h2>
      <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500">Acompanhe abertura, implantação, conclusão e ganho estimado com uma leitura rápida e limpa para tomada de decisão.</p>
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div class="rounded-3xl border border-slate-200 bg-slate-50/80 p-4">
        <p class="text-xs font-bold text-slate-500">Taxa de conclusão</p>
        <p class="mt-2 text-3xl font-black text-slate-950"><?= $completionRate ?>%</p>
        <div class="mt-3 h-2 overflow-hidden rounded-full bg-white">
          <div class="h-full rounded-full bg-emerald-500" style="width: <?= $completionRate ?>%"></div>
        </div>
      </div>
      <div class="rounded-3xl border border-slate-200 bg-slate-50/80 p-4">
        <p class="text-xs font-bold text-slate-500">Implantação</p>
        <p class="mt-2 text-3xl font-black text-slate-950"><?= $implantationRate ?>%</p>
        <div class="mt-3 h-2 overflow-hidden rounded-full bg-white">
          <div class="h-full rounded-full bg-blue-500" style="width: <?= $implantationRate ?>%"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
  <?php foreach ($cards as $card): ?>
    <article class="metric-card rounded-[1.35rem] border border-slate-200/85 bg-white/90 p-5 shadow-sm shadow-slate-200/70">
      <div class="flex items-start justify-between gap-4">
        <div>
          <p class="text-sm font-bold text-slate-500"><?= e($card['label']) ?></p>
          <p class="mt-3 text-3xl font-black tracking-tight text-slate-950"><?= e((string) $card['value']) ?></p>
        </div>
        <span class="metric-icon metric-<?= e($card['tone']) ?>"><i data-lucide="<?= e($card['icon']) ?>" class="h-5 w-5"></i></span>
      </div>
    </article>
  <?php endforeach; ?>
</section>

<section class="mt-5 grid gap-5 xl:grid-cols-[1.25fr_.75fr]">
  <article class="soft-card rounded-[1.5rem] p-5 sm:p-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h2 class="text-lg font-black text-slate-950">Evolução mensal</h2>
        <p class="text-sm text-slate-500">Volume de melhorias abertas por mês</p>
      </div>
      <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-black text-blue-700">
        <i data-lucide="activity" class="h-4 w-4"></i> Tendência
      </span>
    </div>
    <canvas class="mt-6 h-72 w-full" data-chart-type="area" data-chart='<?= e(json_encode($stats['monthly'], JSON_UNESCAPED_UNICODE)) ?>'></canvas>
  </article>

  <article class="soft-card rounded-[1.5rem] p-5 sm:p-6">
    <div class="flex items-center justify-between gap-3">
      <div>
        <h2 class="text-lg font-black text-slate-950">Status</h2>
        <p class="text-sm text-slate-500">Distribuição atual</p>
      </div>
      <i data-lucide="pie-chart" class="h-5 w-5 text-blue-600"></i>
    </div>
    <div class="mt-5 space-y-3">
      <?php foreach ($stats['byStatus'] as $row): ?>
        <?php $percent = $stats['total'] > 0 ? round(((int) $row['total'] / $stats['total']) * 100) : 0; ?>
        <div class="rounded-2xl border border-slate-200 bg-white p-3">
          <div class="flex items-center justify-between gap-3">
            <span class="badge ring-1 <?= $statusColors[$row['status']] ?? 'bg-slate-50 text-slate-700 ring-slate-200' ?>"><?= e($row['status']) ?></span>
            <span class="text-sm font-black text-slate-900"><?= (int) $row['total'] ?></span>
          </div>
          <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-slate-100">
            <div class="h-full rounded-full bg-blue-500" style="width: <?= $percent ?>%"></div>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (!$stats['byStatus']): ?>
        <p class="rounded-2xl bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">Nenhuma melhoria cadastrada ainda.</p>
      <?php endif; ?>
    </div>
  </article>
</section>

<section class="mt-5 grid gap-5 xl:grid-cols-[.9fr_1.1fr]">
  <article class="soft-card rounded-[1.5rem] p-5 sm:p-6">
    <h2 class="text-lg font-black text-slate-950">Ranking de departamentos</h2>
    <p class="mt-1 text-sm text-slate-500">Áreas com mais iniciativas registradas</p>
    <div class="mt-5 space-y-4">
      <?php foreach ($stats['byDepartment'] as $row): ?>
        <?php $percent = min(100, ((int) $row['total'] / max(1, (int) $stats['total'])) * 100); ?>
        <div>
          <div class="mb-1.5 flex justify-between text-sm font-bold text-slate-600">
            <span><?= e($row['nome']) ?></span>
            <span><?= (int) $row['total'] ?></span>
          </div>
          <div class="h-2 overflow-hidden rounded-full bg-slate-100">
            <div class="h-full rounded-full bg-slate-800" style="width: <?= $percent ?>%"></div>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (!$stats['byDepartment']): ?>
        <p class="rounded-2xl bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">Nenhum departamento com melhoria ainda.</p>
      <?php endif; ?>
    </div>
  </article>

  <article class="soft-card rounded-[1.5rem] p-5 sm:p-6">
    <div class="flex items-center justify-between gap-3">
      <div>
        <h2 class="text-lg font-black text-slate-950">Equipe ativa</h2>
        <p class="text-sm text-slate-500">Usuários habilitados no sistema</p>
      </div>
      <?php if (can('super_admin')): ?>
        <a class="btn-secondary !py-2 text-sm" href="<?= url('/usuarios') ?>">Ver usuários</a>
      <?php endif; ?>
    </div>
    <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
      <?php foreach (array_slice($users, 0, 6) as $member): ?>
        <div class="rounded-2xl border border-slate-200 bg-white p-4">
          <p class="truncate font-black text-slate-900"><?= e($member['nome']) ?></p>
          <p class="mt-1 truncate text-sm text-slate-500"><?= e($member['perfil']) ?> · <?= e($member['status']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </article>
</section>
