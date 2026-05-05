<div class="mb-8 text-center">
  <div class="mx-auto grid h-14 w-14 place-items-center rounded-3xl bg-blue-600 font-black text-white shadow-lg shadow-blue-600/25">MC</div>
  <h2 class="mt-5 text-3xl font-black text-slate-950">Entrar no sistema</h2>
  <p class="mt-2 text-sm text-slate-500">Acesse sua conta para acompanhar melhorias e ações.</p>
</div>

<form method="post" action="<?= url('/login') ?>" class="space-y-4">
  <?= csrf_field() ?>
  <label class="block">
    <span class="mb-2 block text-sm font-bold text-slate-700">E-mail</span>
    <input class="form-input" type="email" name="email" value="<?= e(old('email')) ?>" required autocomplete="email" placeholder="seu@email.com">
  </label>
  <label class="block">
    <span class="mb-2 block text-sm font-bold text-slate-700">Senha</span>
    <input class="form-input" type="password" name="senha" required autocomplete="current-password" placeholder="••••••••">
  </label>
  <button class="btn-primary w-full" type="submit">Entrar</button>
  <div class="text-center">
    <a href="<?= url('/recuperar-senha') ?>" class="text-sm font-bold text-blue-600 hover:text-blue-700">Recuperar senha</a>
  </div>
</form>
