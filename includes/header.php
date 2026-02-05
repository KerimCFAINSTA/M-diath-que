<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Médiathèque de Versailles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icônes Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fichier CSS personnalisé -->
    <link rel="stylesheet" href="public/css/style.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-book-fill me-2"></i> Médiathèque de Versailles
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=dashboard"><i class="bi bi-house-fill"></i> Tableau de bord</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=livres"><i class="bi bi-book"></i> Livres</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=emprunts"><i class="bi bi-journal-check"></i> Emprunts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=utilisateurs"><i class="bi bi-people-fill"></i> Utilisateurs</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Messages de succès/erreur -->
<?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <i class="bi bi-check-circle-fill"></i> Opération réussie !
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        <i class="bi bi-x-circle-fill"></i> Une erreur s'est produite.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Début du contenu principal -->
<main>