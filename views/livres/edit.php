<?php include 'includes/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Modifier un livre</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-x-circle-fill"></i> <?= $error ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">ISBN *</label>
                                <input type="text" name="isbn" class="form-control" 
                                       value="<?= htmlspecialchars($livre['isbn']) ?>" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Titre *</label>
                                <input type="text" name="titre" class="form-control" 
                                       value="<?= htmlspecialchars($livre['titre']) ?>" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Auteur *</label>
                                <input type="text" name="auteur" class="form-control" 
                                       value="<?= htmlspecialchars($livre['auteur']) ?>" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Éditeur</label>
                                <input type="text" name="editeur" class="form-control" 
                                       value="<?= htmlspecialchars($livre['editeur']) ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Année de publication</label>
                                <input type="number" name="annee_publication" class="form-control" 
                                       value="<?= $livre['annee_publication'] ?>" 
                                       min="1800" max="<?= date('Y') ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Catégorie *</label>
                                <select name="categorie" class="form-select" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="Roman" <?= $livre['categorie'] === 'Roman' ? 'selected' : '' ?>>Roman</option>
                                    <option value="Jeunesse" <?= $livre['categorie'] === 'Jeunesse' ? 'selected' : '' ?>>Jeunesse</option>
                                    <option value="Science-Fiction" <?= $livre['categorie'] === 'Science-Fiction' ? 'selected' : '' ?>>Science-Fiction</option>
                                    <option value="Classique" <?= $livre['categorie'] === 'Classique' ? 'selected' : '' ?>>Classique</option>
                                    <option value="Histoire" <?= $livre['categorie'] === 'Histoire' ? 'selected' : '' ?>>Histoire</option>
                                    <option value="Biographie" <?= $livre['categorie'] === 'Biographie' ? 'selected' : '' ?>>Biographie</option>
                                    <option value="Poésie" <?= $livre['categorie'] === 'Poésie' ? 'selected' : '' ?>>Poésie</option>
                                    <option value="BD" <?= $livre['categorie'] === 'BD' ? 'selected' : '' ?>>Bande Dessinée</option>
                                    <option value="Documentaire" <?= $livre['categorie'] === 'Documentaire' ? 'selected' : '' ?>>Documentaire</option>
                                    <option value="Autre" <?= $livre['categorie'] === 'Autre' ? 'selected' : '' ?>>Autre</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Nombre total d'exemplaires *</label>
                                <input type="number" name="nombre_exemplaires" class="form-control" 
                                       value="<?= $livre['nombre_exemplaires'] ?>" min="1" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Exemplaires disponibles *</label>
                                <input type="number" name="exemplaires_disponibles" class="form-control" 
                                       value="<?= $livre['exemplaires_disponibles'] ?>" min="0" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Emplacement *</label>
                                <input type="text" name="emplacement" class="form-control" 
                                       value="<?= htmlspecialchars($livre['emplacement']) ?>" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Statut *</label>
                                <select name="statut" class="form-select" required>
                                    <option value="disponible" <?= $livre['statut'] === 'disponible' ? 'selected' : '' ?>>Disponible</option>
                                    <option value="emprunte" <?= $livre['statut'] === 'emprunte' ? 'selected' : '' ?>>Emprunté</option>
                                    <option value="perdu" <?= $livre['statut'] === 'perdu' ? 'selected' : '' ?>>Perdu</option>
                                    <option value="maintenance" <?= $livre['statut'] === 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-4 d-flex justify-content-between">
                            <a href="index.php?page=livres" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>