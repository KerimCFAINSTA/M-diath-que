<?php include 'includes/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-person-plus"></i> Ajouter un utilisateur</h4>
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
                                       placeholder="Dupont" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Prénom *</label>
                                <input type="text" name="prenom" class="form-control" 
                                       placeholder="Jean" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" 
                                       placeholder="jean.dupont@email.com" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" name="telephone" class="form-control" 
                                       placeholder="0123456789">
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label">Type d'utilisateur *</label>
                                <select name="type_utilisateur" id="type_utilisateur" class="form-select" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="public">Public</option>
                                    <option value="ecole">École</option>
                                    <option value="admin">Administrateur</option>
                                </select>
                            </div>
                            
                            <div class="col-md-12" id="ecole-field" style="display: none;">
                                <label class="form-label">Nom de l'école</label>
                                <input type="text" name="nom_ecole" id="nom_ecole" class="form-control" 
                                       placeholder="École Primaire Versailles">
                                <small class="form-text text-muted">Obligatoire si type = École</small>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php?page=utilisateurs" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Créer l'utilisateur
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
        nomEcoleInput.value = '';
    }
});
</script>

<?php include 'includes/footer.php'; ?>