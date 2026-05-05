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
  <main class="relative z-10 flex min-h-screen items-center justify-center">
    <section class="flex w-full items-center justify-center p-4 sm:p-6">
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
