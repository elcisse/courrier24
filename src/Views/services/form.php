<div class="container" style="max-width:640px;">
    <h1 class="mb-4"><?= e($title ?? 'Service') ?></h1>
    <form method="post" action="<?= url(isset($row['id']) && $row['id'] ? '/services/update' : '/services/store') ?>" class="card card-body">
        <?= csrf_field() ?>
        <?php if (!empty($row['id'])): ?>
            <input type="hidden" name="id" value="<?= e($row['id']) ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">Code</label>
            <input type="text" name="code" class="form-control" required value="<?= e($row['code'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libelle" class="form-control" required value="<?= e($row['libelle'] ?? '') ?>">
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="actif" id="fActif" <?= (!isset($row['actif']) || $row['actif']) ? 'checked' : '' ?>>
            <label class="form-check-label" for="fActif">Actif</label>
        </div>
        <button class="btn btn-primary">Enregistrer</button>
        <a class="btn btn-light" href="<?= url('/services') ?>">Annuler</a>
    </form>
</div>
