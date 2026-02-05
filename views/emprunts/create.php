<?php include 'includes/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Créer un nouvel emprunt</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-x-circle-fill"></i> <?= $error ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Emprunteur *</label>
                            <select name="utilisateur_id" class="form-select" required>
                                <option value="">-- Sélectionner un utilisateur --</option>
                                <?php foreach ($utilisateursActifs as $u): ?>
                                    <option value="<?= $u['id'] ?>">
                                        <?= htmlspecialchars($u['nom'] . ' ' . $u['prenom']) ?>
                                        (<?= ucfirst($u['type_utilisateur']) ?>)
                                        <?php if ($u['nom_ecole']): ?>
                                            - <?= htmlspecialchars($u['nom_ecole']) ?>
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">Sélectionnez l'utilisateur qui emprunte le livre</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Livre *</label>
                            <select name="livre_id" class="form-select" required>
                                <option value="">-- Sélectionner un livre --</option>
                                <?php foreach ($livresDisponibles as $l): ?>
                                    <option value="<?= $l['id'] ?>">
                                        <?= htmlspecialchars($l['titre']) ?> - <?= htmlspecialchars($l['auteur']) ?>
                                        (<?= $l['exemplaires_disponibles'] ?> disponible(s))
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">Seuls les livres disponibles sont affichés</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Date de retour prévue *</label>
                            <input type="date" 
                                   name="date_retour_prevue" 
                                   class="form-control" 
                                   min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                   value="<?= date('Y-m-d', strtotime('+14 days')) ?>"
                                   required>
                            <small class="form-text text-muted">Durée standard : 14 jours pour le public, 30 jours pour les écoles</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Commentaire</label>
                            <textarea name="commentaire" class="form-control" rows="3" 
                                      placeholder="Ajouter une note (optionnel)"></textarea>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill"></i> 
                            <strong>Information :</strong> Les utilisateurs ayant des emprunts en retard ne peuvent pas emprunter de nouveaux livres.
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php?page=emprunts" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Créer l'emprunt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Ajuster automatiquement la date de retour selon le type d'utilisateur
document.querySelector('select[name="utilisateur_id"]').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var typeUtilisateur = selectedOption.text;
    var dateRetourInput = document.querySelector('input[name="date_retour_prevue"]');
    
    // Les écoles peuvent emprunter pour 30 jours, le public pour 14 jours
    var jours = typeUtilisateur.includes('ecole') || typeUtilisateur.includes('Ecole') ? 30 : 14;
    
    var dateRetour = new Date();
    dateRetour.setDate(dateRetour.getDate() + jours);
    
    var year = dateRetour.getFullYear();
    var month = String(dateRetour.getMonth() + 1).padStart(2, '0');
    var day = String(dateRetour.getDate()).padStart(2, '0');
    
    dateRetourInput.value = year + '-' + month + '-' + day;
});
</script>

<?php include 'includes/footer.php'; ?>