<?php include 'includes/header.php'; ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-people-fill"></i> Gestion des utilisateurs</h1>
        <a href="index.php?page=utilisateur_create" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Nouvel utilisateur
        </a>
    </div>
    
    <!-- Barre de recherche et filtres -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <form method="GET" action="index.php">
                        <input type="hidden" name="page" value="utilisateurs">
                        <div class="input-group">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Rechercher un utilisateur..."
                                   value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Rechercher
                            </button>
                            <?php if (isset($_GET['search'])): ?>
                                <a href="index.php?page=utilisateurs" class="btn btn-outline-secondary">
                                    <i class="bi bi-x"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="btn-group w-100" role="group">
                        <a href="index.php?page=utilisateurs" class="btn btn-<?= !isset($_GET['filter']) || $_GET['filter'] === 'all' ? 'primary' : 'outline-primary' ?>">
                            Tous
                        </a>
                        <a href="index.php?page=utilisateurs&filter=public" class="btn btn-<?= isset($_GET['filter']) && $_GET['filter'] === 'public' ? 'info' : 'outline-info' ?>">
                            Public
                        </a>
                        <a href="index.php?page=utilisateurs&filter=ecole" class="btn btn-<?= isset($_GET['filter']) && $_GET['filter'] === 'ecole' ? 'warning' : 'outline-warning' ?>">
                            Écoles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tableau des utilisateurs -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Type</th>
                            <th>École</th>
                            <th>Date inscription</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($utilisateurs) > 0): ?>
                            <?php foreach ($utilisateurs as $u): ?>
                            <tr>
                                <td><?= $u['id'] ?></td>
                                <td><strong><?= htmlspecialchars($u['nom'] . ' ' . $u['prenom']) ?></strong></td>
                                <td><?= htmlspecialchars($u['email']) ?></td>
                                <td><?= htmlspecialchars($u['telephone']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $u['type_utilisateur'] === 'ecole' ? 'warning' : ($u['type_utilisateur'] === 'admin' ? 'danger' : 'info') ?>">
                                        <?= ucfirst($u['type_utilisateur']) ?>
                                    </span>
                                </td>
                                <td><?= $u['nom_ecole'] ? htmlspecialchars($u['nom_ecole']) : '-' ?></td>
                                <td><?= date('d/m/Y', strtotime($u['date_inscription'])) ?></td>
                                <td>
                                    <span class="badge bg-<?= $u['actif'] ? 'success' : 'secondary' ?>">
                                        <?= $u['actif'] ? 'Actif' : 'Inactif' ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="index.php?page=utilisateur_edit&id=<?= $u['id'] ?>" 
                                       class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="index.php?page=utilisateur_delete&id=<?= $u['id'] ?>" 
                                       class="btn btn-sm btn-danger" 
                                       title="Supprimer"
                                       onclick="return confirmerSuppression('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <p class="text-muted mb-0">Aucun utilisateur trouvé.</p>
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