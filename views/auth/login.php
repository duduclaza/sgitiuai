<div class="mb-8">
  <div class="grid h-14 w-14 place-items-center rounded-3xl bg-blue-500 font-black text-white shadow-lg shadow-blue-500/30">MC</div>
  <h2 class="mt-6 text-3xl font-black tracking-tight text-white">Entrar no sistema</h2>
  <p class="mt-2 text-sm leading-6 text-slate-400">Acesse o painel de melhoria contínua com segurança.</p>
</div>

<form method="post" action="<?= url('/login') ?>" class="space-y-4">
  <?= csrf_field() ?>
  <label class="block">
    <span class="mb-2 block text-sm font-bold text-slate-300">E-mail</span>
    <input class="form-input auth-input" type="email" name="email" value="<?= e(old('email')) ?>" required autocomplete="email" placeholder="seu@email.com">
  </label>

  <label class="block">
    <span class="mb-2 block text-sm font-bold text-slate-300">Senha</span>
    <span class="relative block">
      <input id="login-password" class="form-input auth-input pr-12" type="password" name="senha" required autocomplete="current-password" placeholder="Digite sua senha">
      <button type="button" class="password-eye" data-password-toggle="login-password" aria-label="Mostrar senha">
        <i data-lucide="eye" class="h-5 w-5"></i>
      </button>
    </span>
  </label>

  <button class="btn-primary w-full !rounded-2xl !py-3" type="submit">Entrar</button>

  <div class="flex items-center justify-between gap-3 text-sm">
    <span class="text-slate-500">Ambiente seguro</span>
    <a href="<?= url('/recuperar-senha') ?>" class="font-bold text-blue-300 hover:text-blue-200">Recuperar senha</a>
  </div>
</form>
