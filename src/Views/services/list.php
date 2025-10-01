<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0"><?= e($title ?? 'Services') ?></h1>
        <a class="btn btn-primary" href="<?= url('/services/create') ?>">+ Nouveau</a>
    </div>

    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?= e($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>

    <div class="table-responsive card">
        <table class="table table-striped mb-0">
            <thead class="table-light">
            <tr><th>#</th><th>Code</th><th>Libellé</th><th>Actif</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= e($r['id']) ?></td>
                    <td><?= e($r['code']) ?></td>
                    <td><?= e($r['libelle']) ?></td>
                    <td><?= $r['actif'] ? '✅' : '❌' ?></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-secondary" href="<?= url('/services/edit?id='.$r['id']) ?>">Éditer</a>
                        <form action="<?= url('/services/delete') ?>" method="post" class="d-inline" onsubmit="return confirm('Supprimer ?');">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= e($r['id']) ?>">
                            <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
