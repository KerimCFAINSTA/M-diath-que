<?php include 'includes/header.php'; ?>

<div class="container my-5">
    <h1 class="mb-4"><i class="bi bi-speedometer2"></i> Tableau de bord</h1>
    
    <!-- Statistiques -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-book-fill"></i> Livres</h5>
                    <h2><?= $statsLivres['total_livres'] ?></h2>
                    <p class="mb-0">au catalogue</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-check-circle-fill"></i> Disponibles</h5>
                    <h2><?= $statsLivres['exemplaires_disponibles'] ?></h2>
                    <p class="mb-0">exemplaires</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-clock-fill"></i> En cours</h5>
                    <h2><?= $statsEmprunts['emprunts_en_cours'] ?></h2>
                    <p class="mb-0">emprunts</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-exclamation-triangle-fill"></i> En retard</h5>
                    <h2><?= $statsEmprunts['emprunts_en_retard'] ?></h2>
                    <p class="mb-0">emprunts</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-people-fill"></i> Utilisateurs</h5>
                    <h2><?= $statsUtilisateurs['total_utilisateurs'] ?></h2>
                    <p class="mb-0">inscrits</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-secondary text-white shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-x-circle-fill"></i> Perdus</h5>
                    <h2><?= $statsEmprunts['emprunts_perdus'] ?></h2>
                    <p class="mb-0">livres</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Actions rapides -->
    <div class="card mb-4 shadow">
        <div class="card-body">
            <h5 class="card-title mb-3"><i class="bi bi-lightning-fill"></i> Actions rapides</h5>
            <a href="index.php?page=emprunt_create" class="btn btn-primary me-2 mb-2">
                <i class="bi bi-plus-circle"></i> Nouvel emprunt
            </a>
            <a href="index.php?page=livre_create" class="btn btn-success me-2 mb-2">
                <i class="bi bi-book"></i> Ajouter un livre
            </a>
            <a href="index.php?page=utilisateur_create" class="btn btn-info mb-2">
                <i class="bi bi-person-plus"></i> Nouvel utilisateur
            </a>
        </div>
    </div>
    
    <!-- Emprunts en retard -->
    <?php if (count($empruntsRetard) > 0): ?>
    <div class="card mb-4 shadow border-danger">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Emprunts en retard</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Livre</th>
                            <th>Emprunteur</th>
                            <th>Date retour prévue</th>
                            <th>Jours de retard</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($empruntsRetard as $e): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($e['titre']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($e['auteur']) ?></small></td>
                            <td><?= htmlspecialchars($e['nom'] . ' ' . $e['prenom']) ?></td>
                            <td><?= date('d/m/Y', strtotime($e['date_retour_prevue'])) ?></td>
                            <td><span class="badge bg-danger"><?= $e['jours_retard'] ?> jour(s)</span></td>
                            <td>
                                <?= htmlspecialchars($e['email']) ?><br>
                                <small><?= htmlspecialchars($e['telephone']) ?></small>
                            </td>
                            <td>
                                <a href="index.php?page=emprunt_retour&id=<?= $e['id'] ?>" 
                                   class="btn btn-sm btn-success"
                                   onclick="return confirm('Confirmer le retour ?')">
                                    <i class="bi bi-check-circle"></i> Retour
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Derniers emprunts en cours -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-journal-check"></i> Emprunts en cours (10 derniers)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Livre</th>
                            <th>Emprunteur</th>
                            <th>Date emprunt</th>
                            <th>Retour prévu</th>
                            <th>Jours restants</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $count = 0;
                        foreach ($empruntsEnCours as $e): 
                            if ($count >= 10) break;
                            $count++;
                            $badgeClass = $e['jours_restants'] < 0 ? 'danger' : ($e['jours_restants'] <= 3 ? 'warning' : 'success');
                        ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($e['titre']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($e['auteur']) ?></small></td>
                            <td><?= htmlspecialchars($e['nom'] . ' ' . $e['prenom']) ?></td>
                            <td><?= date('d/m/Y', strtotime($e['date_emprunt'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($e['date_retour_prevue'])) ?></td>
                            <td><span class="badge bg-<?= $badgeClass ?>"><?= abs($e['jours_restants']) ?> jour(s)</span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <a href="index.php?page=emprunts" class="btn btn-outline-primary">Voir tous les emprunts</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>