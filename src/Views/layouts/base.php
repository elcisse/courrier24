
/<?php if (auth_check()): ?>
  <span class="navbar-text me-3">👋 <?= e($_SESSION['auth_prenom_nom'] ?? '') ?></span>
<?php endif; ?>
<?php if (in_roles(['ADMIN'])): ?>
    <li class="nav-item"><a class="nav-link" href="<?= url('/services') ?>">🏢 Services</a></li>
<?php endif; ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= e($title ?? 'Courrier24') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f7f7f9; }
        .sidebar { width: 240px; }
        .content { margin-left: 240px; }
        @media (max-width: 991px){ .content { margin-left: 0; } }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= url('/') ?>">Courrier24</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="topbar" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <?php if (auth_check()): ?>
                    <li class="nav-item">
                        <form method="post" action="<?= url('/logout') ?>" class="mb-0">
                            <?= csrf_field() ?>
                            <button class="btn btn-sm btn-outline-light">Se déconnecter</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/login') ?>">Se connecter</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="d-flex">
    <aside class="sidebar bg-white border-end d-none d-lg-block position-fixed top-0 bottom-0 mt-5 pt-3">
        <ul class="nav flex-column px-3">
            <li class="nav-item"><a class="nav-link" href="<?= url('/') ?>">🏠 Tableau de bord</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= url('/courriers') ?>">✉️ Courriers</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= url('/services') ?>">🏢 Services</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= url('/utilisateurs') ?>">👥 Utilisateurs</a></li>
        </ul>
    </aside>

    <main class="content container-fluid p-4">
        <?php include $viewFile; ?>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
