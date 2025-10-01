<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0"><?= e($title ?? 'Courriers') ?></h1>
        <a class="btn btn-primary" href="<?= url('/courriers/create') ?>">+ Nouveau</a>
    </div>

    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?= e($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>

    <div class="table-responsive card">
        <table class="table table-striped mb-0">
            <thead class="table-light">
            <tr><th>#</th><th>Type</th><th>Réf</th><th>Objet</th><th>Service cible</th><th>Statut</th><th>Créé le</th></tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= e($r['id']) ?></td>
                    <td><?= e($r['type']) ?></td>
                    <td><?= e($r['ref']) ?></td>
                    <td><?= e($r['objet']) ?></td>
                    <td><?= e($r['service_cible'] ?? '') ?></td>
                    <td><?= e($r['statut']) ?></td>
                    <td><?= e($r['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
