<?php include 'includes/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Ajouter un livre</h4>
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
                                       placeholder="978-2-07-061275-8" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Titre *</label>
                                <input type="text" name="titre" class="form-control" 
                                       placeholder="Le Petit Prince" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Auteur *</label>
                                <input type="text" name="auteur" class="form-control" 
                                       placeholder="Antoine de Saint-Exupéry" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Éditeur</label>
                                <input type="text" name="editeur" class="form-control" 
                                       placeholder="Gallimard">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Année de publication</label>
                                <input type="number" name="annee_publication" class="form-control" 
                                       placeholder="2024" min="1800" max="<?= date('Y') ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Catégorie *</label>
                                <select name="categorie" class="form-select" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="Roman">Roman</option>
                                    <option value="Jeunesse">Jeunesse</option>
                                    <option value="Science-Fiction">Science-Fiction</option>
                                    <option value="Classique">Classique</option>
                                    <option value="Histoire">Histoire</option>
                                    <option value="Biographie">Biographie</option>
                                    <option value="Poésie">Poésie</option>
                                    <option value="BD">Bande Dessinée</option>
                                    <option value="Documentaire">Documentaire</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Nombre d'exemplaires *</label>
                                <input type="number" name="nombre_exemplaires" class="form-control" 
                                       value="1" min="1" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Emplacement *</label>
                                <input type="text" name="emplacement" class="form-control" 
                                       placeholder="Rayon A1" required>
                            </div>
                        </div>
                        
                        <div class="mt-4 d-flex justify-content-between">
                            <a href="index.php?page=livres" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>