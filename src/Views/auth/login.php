<div class="container" style="max-width:480px;">
    <h1 class="mb-4"><?= e($title ?? 'Connexion') ?></h1>
    <form method="post" action="<?= url('/login') ?>" class="card card-body">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Login</label>
            <input type="text" name="login" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100">Se connecter</button>
    </form>
</div>
