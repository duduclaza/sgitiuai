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
<body class="auth-body min-h-screen text-slate-100">
  <canvas class="auth-particles" data-particles aria-hidden="true"></canvas>
  <main class="relative z-10 grid min-h-screen lg:grid-cols-[1fr_520px]">
    <section class="hidden flex-col justify-between p-10 lg:flex xl:p-14">
      <div class="inline-flex items-center gap-3">
        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-blue-500 text-lg font-black text-white shadow-lg shadow-blue-500/30">MC</span>
        <span class="text-lg font-black text-white"><?= e(config('app.name')) ?></span>
      </div>

      <div class="max-w-2xl">
        <p class="text-xs font-black uppercase tracking-normal text-blue-300">Melhoria contínua corporativa</p>
        <h1 class="mt-4 text-5xl font-black leading-tight text-white xl:text-6xl">Gestão limpa para decisões melhores.</h1>
        <p class="mt-5 max-w-xl text-base leading-7 text-slate-300">Organize oportunidades, análise, ações e indicadores em um ambiente seguro, moderno e pronto para evoluir com IA.</p>
        <div class="mt-8 grid max-w-xl grid-cols-3 gap-3">
          <div class="rounded-3xl border border-white/10 bg-white/[0.06] p-4 backdrop-blur-xl">
            <p class="text-2xl font-black text-white">PDCA</p>
            <p class="mt-1 text-xs font-bold text-slate-400">Ciclo de ação</p>
          </div>
          <div class="rounded-3xl border border-white/10 bg-white/[0.06] p-4 backdrop-blur-xl">
            <p class="text-2xl font-black text-white">SWOT</p>
            <p class="mt-1 text-xs font-bold text-slate-400">Análise clara</p>
          </div>
          <div class="rounded-3xl border border-white/10 bg-white/[0.06] p-4 backdrop-blur-xl">
            <p class="text-2xl font-black text-white">5W2H</p>
            <p class="mt-1 text-xs font-bold text-slate-400">Plano objetivo</p>
          </div>
        </div>
      </div>

      <p class="text-sm text-slate-500">© <?= date('Y') ?> <?= e(config('app.name')) ?></p>
    </section>

    <section class="flex min-h-screen items-center justify-center p-4 sm:p-6">
      <div class="auth-card w-full max-w-md rounded-[1.75rem] border border-white/10 bg-slate-950/72 p-6 shadow-2xl shadow-black/30 backdrop-blur-2xl sm:p-8">
        <?php if ($message = flash('success')): ?>
          <div class="mb-5 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-sm font-semibold text-emerald-200"><?= e($message) ?></div>
        <?php endif; ?>
        <?php if ($message = flash('error')): ?>
          <div class="mb-5 rounded-2xl border border-red-400/20 bg-red-400/10 px-4 py-3 text-sm font-semibold text-red-200"><?= e($message) ?></div>
        <?php endif; ?>
        <?= $content ?>
      </div>
    </section>
  </main>
  <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
