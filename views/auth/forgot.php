<div class="mb-8 text-center">
  <div class="mx-auto grid h-14 w-14 place-items-center rounded-3xl bg-blue-600 font-black text-white shadow-lg shadow-blue-600/25">MC</div>
  <h2 class="mt-5 text-3xl font-black text-slate-950">Recuperar senha</h2>
  <p class="mt-2 text-sm text-slate-500">Informe seu e-mail para iniciar o processo com o administrador.</p>
</div>

<form method="post" action="<?= url('/recuperar-senha') ?>" class="space-y-4">
  <?= csrf_field() ?>
  <label class="block">
    <span class="mb-2 block text-sm font-bold text-slate-700">E-mail</span>
    <input class="form-input" type="email" name="email" required autocomplete="email" placeholder="seu@email.com">
  </label>
  <button class="btn-primary w-full" type="submit">Solicitar recuperação</button>
  <div class="text-center">
    <a href="<?= url('/login') ?>" class="text-sm font-bold text-slate-600 hover:text-blue-700">Voltar para login</a>
  </div>
</form>
