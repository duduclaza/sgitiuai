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
  <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>
<body class="min-h-screen text-slate-900">
  <main class="min-h-screen grid lg:grid-cols-[1.05fr_.95fr]">
    <section class="hidden lg:flex flex-col justify-between p-12">
      <div class="inline-flex items-center gap-3">
        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-blue-600 text-lg font-black text-white">MC</span>
        <span class="text-xl font-black"><?= e(config('app.name')) ?></span>
      </div>
      <div class="max-w-xl">
        <p class="text-sm font-bold uppercase text-blue-600">Melhoria Contínua</p>
        <h1 class="mt-4 text-5xl font-black leading-tight text-slate-950">Gestão visual, segura e pronta para evoluir.</h1>
        <p class="mt-5 text-lg text-slate-600">PDCA, SWOT, 5W2H, ações, reuniões, relatórios e IA em uma experiência limpa no estilo iOS/macOS.</p>
      </div>
      <p class="text-sm text-slate-500">© <?= date('Y') ?> <?= e(config('app.name')) ?></p>
    </section>
    <section class="flex min-h-screen items-center justify-center p-4 sm:p-6">
      <div class="w-full max-w-md rounded-[1.5rem] bg-white/90 p-6 shadow-2xl shadow-slate-300/60 ring-1 ring-slate-200 backdrop-blur-xl sm:rounded-[2rem] sm:p-8">
        <?php if ($message = flash('success')): ?>
          <div class="mb-5 rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700"><?= e($message) ?></div>
        <?php endif; ?>
        <?php if ($message = flash('error')): ?>
          <div class="mb-5 rounded-2xl bg-red-50 px-4 py-3 text-sm font-semibold text-red-700"><?= e($message) ?></div>
        <?php endif; ?>
        <?= $content ?>
      </div>
    </section>
  </main>
</body>
</html>
