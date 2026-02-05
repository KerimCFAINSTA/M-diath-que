<?php include 'includes/header.php'; ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-journal-check"></i> Gestion des emprunts</h1>
        <a href="index.php?page=emprunt_create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouvel emprunt
        </a>
    </div>
    
    <!-- Filtres -->
    <div class="mb-4">
        <a href="index.php?page=emprunts" class="btn btn-<?= !isset($_GET['filter']) || $_GET['filter'] === 'all' ? 'primary' : 'outline-primary' ?>">
            Tous
        </a>
        <a href="index.php?page=emprunts&filter=en_cours" class="btn btn-<?= isset($_GET['filter']) && $_GET['filter'] === 'en_cours' ? 'warning' : 'outline-warning' ?>">
            En cours
        </a>
        <a href="index.php?page=emprunts&filter=en_retard" class="btn btn-<?= isset($_GET['filter']) && $_GET['filter'] === 'en_retard' ? 'danger' : 'outline-danger' ?>">
            En retard
        </a>
    </div>
    
    <!-- Tableau des emprunts -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Livre</th>
                            <th>Emprunteur</th>
                            <th>Type</th>
                            <th>Date emprunt</th>
                            <th>Retour prévu</th>
                            <th>Retour réel</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($emprunts) > 0): ?>
                            <?php foreach ($emprunts as $e): ?>
                            <tr>
                                <td><?= $e['id'] ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($e['titre']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($e['auteur']) ?></small>
                                </td>
                                <td><?= htmlspecialchars($e['nom'] . ' ' . $e['prenom']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $e['type_utilisateur'] === 'ecole' ? 'warning' : 'info' ?>">
                                        <?= ucfirst($e['type_utilisateur']) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($e['date_emprunt'])) ?></td>
                                <td>
                                    <?php 
                                    $dateRetourPrevue = strtotime($e['date_retour_prevue']);
                                    $aujourd_hui = strtotime(date('Y-m-d'));
                                    $enRetard = $dateRetourPrevue < $aujourd_hui && !$e['date_retour_reelle'];
                                    ?>
                                    <span class="<?= $enRetard ? 'text-danger fw-bold' : '' ?>">
                                        <?= date('d/m/Y', $dateRetourPrevue) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $e['date_retour_reelle'] ? date('d/m/Y', strtotime($e['date_retour_reelle'])) : '-' ?>
                                </td>
                                <td>
                                    <?php
                                    $statutBadges = [
                                        'en_cours' => 'warning',
                                        'retard' => 'danger',
                                        'rendu' => 'success',
                                        'perdu' => 'secondary'
                                    ];
                                    $badgeClass = $statutBadges[$e['statut']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?>">
                                        <?= ucfirst(str_replace('_', ' ', $e['statut'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($e['statut'] === 'en_cours' || $e['statut'] === 'retard'): ?>
                                        <a href="index.php?page=emprunt_retour&id=<?= $e['id'] ?>" 
                                           class="btn btn-sm btn-success" 
                                           title="Retour"
                                           onclick="return confirm('Confirmer le retour de ce livre ?')">
                                            <i class="bi bi-check-circle"></i>
                                        </a>
                                        <a href="index.php?page=emprunt_perdu&id=<?= $e['id'] ?>" 
                                           class="btn btn-sm btn-danger" 
                                           title="Marquer comme perdu"
                                           onclick="return confirm('Marquer ce livre comme perdu ?')">
                                            <i class="bi bi-x-circle"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <p class="text-muted mb-0">Aucun emprunt trouvé.</p>
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