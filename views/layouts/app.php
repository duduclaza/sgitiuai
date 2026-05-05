<?php
use App\Core\Auth;
use App\Models\Notification;

$user = Auth::user();
$notificationCount = $user ? (new Notification())->unreadCount((int) $user['id']) : 0;
$menu = [
    ['label' => 'Dashboard', 'url' => '/dashboard', 'icon' => 'layout-dashboard', 'active' => '/dashboard', 'show' => true],
    ['label' => 'Usuários', 'url' => '/usuarios', 'icon' => 'users', 'active' => '/usuarios', 'show' => can('super_admin')],
    ['label' => 'Departamentos', 'url' => '/departamentos', 'icon' => 'building-2', 'active' => '/departamentos', 'show' => can('admin')],
    ['label' => 'Melhorias', 'url' => '/melhorias', 'icon' => 'sparkles', 'active' => '/melhorias', 'show' => can(['admin', 'usuario'])],
    ['label' => 'Reuniões', 'url' => '/reunioes', 'icon' => 'calendar-days', 'active' => '/reunioes', 'show' => can('admin')],
    ['label' => 'PDCA', 'url' => '/pdca', 'icon' => 'refresh-cw', 'active' => '/pdca', 'show' => can('admin')],
    ['label' => 'SWOT', 'url' => '/swot', 'icon' => 'grid-2x2', 'active' => '/swot', 'show' => can('admin')],
    ['label' => '5W2H', 'url' => '/5w2h', 'icon' => 'list-checks', 'active' => '/5w2h', 'show' => can('admin')],
    ['label' => 'Notificações', 'url' => '/notificacoes', 'icon' => 'bell', 'active' => '/notificacoes', 'show' => true],
    ['label' => 'Relatórios', 'url' => '/relatorios', 'icon' => 'file-bar-chart', 'active' => '/relatorios', 'show' => can(['admin', 'usuario'], 'relatorios')],
    ['label' => 'Logs', 'url' => '/logs-auditoria', 'icon' => 'shield-check', 'active' => '/logs-auditoria', 'show' => can('super_admin')],
    ['label' => 'Analista IA', 'url' => '/ia', 'icon' => 'brain-circuit', 'active' => '/ia', 'show' => can(['admin', 'usuario'], 'ia')],
];
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title ?? config('app.name')) ?> - <?= e(config('app.name')) ?></title>
  <script>
    tailwind = { config: { theme: { extend: { colors: { brand: '#2563eb' } } } } };
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>
<body class="text-slate-900">
  <div data-sidebar-close class="fixed inset-0 z-30 hidden bg-slate-950/30 backdrop-blur-sm lg:hidden"></div>
  <aside class="sidebar fixed inset-y-0 left-0 z-40 flex flex-col border-r border-slate-800 bg-slate-950 p-4 shadow-xl shadow-black/30">
    <div class="flex items-center justify-between gap-3">
      <a href="<?= url('/dashboard') ?>" class="flex min-w-0 items-center gap-3">
        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-blue-600 text-sm font-black text-white">MC</span>
        <span class="sidebar-brand-text truncate text-sm font-black leading-tight text-white"><?= e(config('app.name')) ?></span>
      </a>
      <button type="button" data-sidebar-toggle class="grid h-10 w-10 shrink-0 place-items-center rounded-2xl border border-slate-800 text-slate-400 hover:bg-slate-800" title="Recolher menu">
        <i data-lucide="panel-left-close" class="h-5 w-5"></i>
      </button>
    </div>

    <p class="sidebar-section mt-8 px-3 text-xs font-bold uppercase text-slate-400">Módulos</p>
    <nav class="mt-3 flex-1 space-y-1">
      <?php foreach ($menu as $item): ?>
        <?php if (!$item['show']) continue; $active = is_active($item['active']); ?>
        <a href="<?= url($item['url']) ?>" class="nav-item group flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-bold transition <?= $active ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
          <i data-lucide="<?= e($item['icon']) ?>" class="h-5 w-5 shrink-0"></i>
          <span class="sidebar-label truncate"><?= e($item['label']) ?></span>
          <?php if ($item['url'] === '/notificacoes' && $notificationCount > 0): ?>
            <span class="sidebar-label ml-auto rounded-full bg-red-500 px-2 py-0.5 text-xs text-white"><?= $notificationCount ?></span>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="rounded-3xl bg-slate-900 p-3 border border-slate-800">
      <p class="sidebar-label text-xs font-bold text-slate-500">Sessão</p>
      <p class="sidebar-label mt-1 truncate text-sm font-black text-white"><?= e($user['nome'] ?? '') ?></p>
      <p class="sidebar-label truncate text-xs text-slate-400"><?= e($user['perfil'] ?? '') ?></p>
    </div>
  </aside>

  <div class="content-wrap app-shell">
    <header class="sticky top-0 z-20 border-b border-slate-200/75 bg-white/70 px-4 py-3 backdrop-blur-2xl sm:px-6 lg:px-8">
      <div class="flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
          <button type="button" data-sidebar-toggle class="grid h-10 w-10 place-items-center rounded-2xl border border-slate-200 bg-white text-slate-700 lg:hidden">
            <i data-lucide="menu" class="h-5 w-5"></i>
          </button>
          <div class="min-w-0">
            <h1 class="truncate text-base font-black text-slate-950 sm:text-xl"><?= e($title ?? 'Sistema') ?></h1>
            <p class="hidden text-sm text-slate-500 sm:block">Gestão profissional de melhorias contínuas</p>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <a href="<?= url('/notificacoes') ?>" class="relative grid h-11 w-11 place-items-center rounded-2xl border border-slate-200 bg-white text-slate-700">
            <i data-lucide="bell" class="h-5 w-5"></i>
            <?php if ($notificationCount > 0): ?><span class="absolute -right-1 -top-1 grid h-5 min-w-5 place-items-center rounded-full bg-red-500 px-1 text-xs font-bold text-white"><?= $notificationCount ?></span><?php endif; ?>
          </a>
          <form method="post" action="<?= url('/logout') ?>">
            <?= csrf_field() ?>
            <button class="grid h-11 w-11 place-items-center rounded-2xl border border-slate-200 bg-white text-slate-700" title="Sair">
              <i data-lucide="log-out" class="h-5 w-5"></i>
            </button>
          </form>
        </div>
      </div>
    </header>

    <main class="p-4 sm:p-6 lg:p-8">
      <?php if ($message = flash('success')): ?>
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700"><?= e($message) ?></div>
      <?php endif; ?>
      <?php if ($message = flash('error')): ?>
        <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700"><?= e($message) ?></div>
      <?php endif; ?>

      <?= $content ?>
    </main>
  </div>
  <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
