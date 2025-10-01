<div class="container" style="max-width:820px;">
    <h1 class="mb-4"><?= e($title ?? 'Nouveau courrier') ?></h1>

    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?= e($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= url('/courriers/store') ?>" class="card card-body">
        <?= csrf_field() ?>

        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="ENTRANT">Entrant</option>
                    <option value="SORTANT">Sortant</option>
                </select>
            </div>
            <div class="col-md-9">
                <label class="form-label">Objet</label>
                <input type="text" name="objet" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Service cible</label>
                <select name="service_cible_id" class="form-select" required>
                    <option value="">— Choisir —</option>
                    <?php foreach ($services as $s): ?>
                        <option value="<?= e($s['id']) ?>"><?= e($s['libelle']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Date réception (si Entrant)</label>
                <input type="date" name="date_reception" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Date envoi (si Sortant)</label>
                <input type="date" name="date_envoi" class="form-control">
            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-primary">Enregistrer</button>
            <a class="btn btn-light" href="<?= url('/courriers') ?>">Annuler</a>
        </div>
    </form>
</div>
