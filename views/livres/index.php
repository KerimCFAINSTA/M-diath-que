<?php include 'includes/header.php'; ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-book"></i> Gestion des livres</h1>
        <a href="index.php?page=livre_create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Ajouter un livre
        </a>
    </div>
    
    <!-- Barre de recherche -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="index.php">
                <input type="hidden" name="page" value="livres">
                <div class="input-group">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Rechercher un livre (titre, auteur, ISBN)..."
                           value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Rechercher
                    </button>
                    <?php if (isset($_GET['search'])): ?>
                        <a href="index.php?page=livres" class="btn btn-outline-secondary">
                            <i class="bi bi-x"></i> Effacer
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Tableau des livres -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>ISBN</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Catégorie</th>
                            <th>Exemplaires</th>
                            <th>Disponibles</th>
                            <th>Emplacement</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($livres) > 0): ?>
                            <?php foreach ($livres as $livre): ?>
                            <tr>
                                <td><small><?= htmlspecialchars($livre['isbn']) ?></small></td>
                                <td><strong><?= htmlspecialchars($livre['titre']) ?></strong></td>
                                <td><?= htmlspecialchars($livre['auteur']) ?></td>
                                <td><span class="badge bg-info"><?= htmlspecialchars($livre['categorie']) ?></span></td>
                                <td class="text-center"><?= $livre['nombre_exemplaires'] ?></td>
                                <td class="text-center">
                                    <span class="badge bg-<?= $livre['exemplaires_disponibles'] > 0 ? 'success' : 'danger' ?>">
                                        <?= $livre['exemplaires_disponibles'] ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($livre['emplacement']) ?></td>
                                <td>
                                    <?php
                                    $statutBadges = [
                                        'disponible' => 'success',
                                        'emprunte' => 'warning',
                                        'perdu' => 'danger',
                                        'maintenance' => 'info'
                                    ];
                                    $badgeClass = $statutBadges[$livre['statut']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?>">
                                        <?= ucfirst($livre['statut']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="index.php?page=livre_edit&id=<?= $livre['id'] ?>" 
                                       class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="index.php?page=livre_delete&id=<?= $livre['id'] ?>" 
                                       class="btn btn-sm btn-danger" 
                                       title="Supprimer"
                                       onclick="return confirmerSuppression('Êtes-vous sûr de vouloir supprimer ce livre ?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <p class="text-muted mb-0">Aucun livre trouvé.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>