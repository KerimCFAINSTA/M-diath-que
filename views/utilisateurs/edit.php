<?php include 'includes/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Modifier un utilisateur</h4>
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
                                <label class="form-label">Nom *</label>
                                <input type="text" name="nom" class="form-control" 
                                       value="<?= htmlspecialchars($utilisateur['nom']) ?>" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Prénom *</label>
                                <input type="text" name="prenom" class="form-control" 
                                       value="<?= htmlspecialchars($utilisateur['prenom']) ?>" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?= htmlspecialchars($utilisateur['email']) ?>" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" name="telephone" class="form-control" 
                                       value="<?= htmlspecialchars($utilisateur['telephone']) ?>">
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label">Type d'utilisateur *</label>
                                <select name="type_utilisateur" id="type_utilisateur" class="form-select" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="public" <?= $utilisateur['type_utilisateur'] === 'public' ? 'selected' : '' ?>>Public</option>
                                    <option value="ecole" <?= $utilisateur['type_utilisateur'] === 'ecole' ? 'selected' : '' ?>>École</option>
                                    <option value="admin" <?= $utilisateur['type_utilisateur'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                                </select>
                            </div>
                            
                            <div class="col-md-12" id="ecole-field" style="display: <?= $utilisateur['type_utilisateur'] === 'ecole' ? 'block' : 'none' ?>;">
                                <label class="form-label">Nom de l'école</label>
                                <input type="text" name="nom_ecole" id="nom_ecole" class="form-control" 
                                       value="<?= htmlspecialchars($utilisateur['nom_ecole']) ?>">
                                <small class="form-text text-muted">Obligatoire si type = École</small>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="actif" id="actif" 
                                           <?= $utilisateur['actif'] ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="actif">
                                        Compte actif
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php?page=utilisateurs" class="btn btn-secondary">
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

<script>
// Afficher/masquer le champ école selon le type d'utilisateur
document.getElementById('type_utilisateur').addEventListener('change', function() {
    var ecoleField = document.getElementById('ecole-field');
    var nomEcoleInput = document.getElementById('nom_ecole');
    
    if(this.value === 'ecole') {
        ecoleField.style.display = 'block';
        nomEcoleInput.required = true;
    } else {
        ecoleField.style.display = 'none';
        nomEcoleInput.required = false;
        if(this.value !== 'ecole') {
            nomEcoleInput.value = '';
        }
    }
});
</script>

<?php include 'includes/footer.php'; ?>