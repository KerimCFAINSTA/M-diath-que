<?php
class Emprunt {
    
    /**
     * Récupère tous les emprunts avec détails
     */
    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("
            SELECT e.*, 
                   l.titre, l.auteur, l.isbn,
                   u.nom, u.prenom, u.email, u.type_utilisateur
            FROM emprunts e
            LEFT JOIN livres l ON e.livre_id = l.id
            LEFT JOIN utilisateurs u ON e.utilisateur_id = u.id
            ORDER BY e.date_emprunt DESC
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Récupère les emprunts en cours
     */
    public static function getEnCours() {
        global $pdo;
        $stmt = $pdo->query("
            SELECT e.*, 
                   l.titre, l.auteur, l.isbn,
                   u.nom, u.prenom, u.email, u.type_utilisateur,
                   DATEDIFF(e.date_retour_prevue, CURDATE()) as jours_restants
            FROM emprunts e
            LEFT JOIN livres l ON e.livre_id = l.id
            LEFT JOIN utilisateurs u ON e.utilisateur_id = u.id
            WHERE e.statut IN ('en_cours', 'retard')
            ORDER BY e.date_retour_prevue ASC
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Récupère les emprunts en retard
     */
    public static function getEnRetard() {
        global $pdo;
        $stmt = $pdo->query("
            SELECT e.*, 
                   l.titre, l.auteur, l.isbn,
                   u.nom, u.prenom, u.email, u.type_utilisateur, u.telephone,
                   DATEDIFF(CURDATE(), e.date_retour_prevue) as jours_retard
            FROM emprunts e
            LEFT JOIN livres l ON e.livre_id = l.id
            LEFT JOIN utilisateurs u ON e.utilisateur_id = u.id
            WHERE e.statut = 'retard'
            OR (e.statut = 'en_cours' AND e.date_retour_prevue < CURDATE())
            ORDER BY e.date_retour_prevue ASC
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Crée un nouvel emprunt
     */
    public static function create($data) {
        global $pdo;
        
        // Vérifier si le livre est disponible
        $livre = Livre::getById($data['livre_id']);
        if (!$livre || $livre['exemplaires_disponibles'] <= 0) {
            return false;
        }
        
        // Démarrer une transaction
        $pdo->beginTransaction();
        
        try {
            // Créer l'emprunt
            $stmt = $pdo->prepare("
                INSERT INTO emprunts (livre_id, utilisateur_id, date_retour_prevue, 
                                     statut, commentaire) 
                VALUES (?, ?, ?, 'en_cours', ?)
            ");
            $stmt->execute([
                $data['livre_id'],
                $data['utilisateur_id'],
                $data['date_retour_prevue'],
                $data['commentaire'] ?? ''
            ]);
            
            // Décrémenter les exemplaires disponibles
            Livre::decrementDisponibles($data['livre_id']);
            
            // Valider la transaction
            $pdo->commit();
            return true;
            
        } catch(Exception $e) {
            // Annuler en cas d'erreur
            $pdo->rollBack();
            return false;
        }
    }
    
    /**
     * Enregistre le retour d'un livre
     */
    public static function retourner($id) {
        global $pdo;
        
        // Récupérer l'emprunt
        $stmt = $pdo->prepare("SELECT * FROM emprunts WHERE id = ?");
        $stmt->execute([$id]);
        $emprunt = $stmt->fetch();
        
        if (!$emprunt) {
            return false;
        }
        
        // Démarrer une transaction
        $pdo->beginTransaction();
        
        try {
            // Mettre à jour l'emprunt
            $stmt = $pdo->prepare("
                UPDATE emprunts 
                SET date_retour_reelle = NOW(), statut = 'rendu' 
                WHERE id = ?
            ");
            $stmt->execute([$id]);
            
            // Incrémenter les exemplaires disponibles
            Livre::incrementDisponibles($emprunt['livre_id']);
            
            // Valider la transaction
            $pdo->commit();
            return true;
            
        } catch(Exception $e) {
            // Annuler en cas d'erreur
            $pdo->rollBack();
            return false;
        }
    }
    
    /**
     * Marquer un emprunt comme perdu
     */
    public static function marquerPerdu($id) {
        global $pdo;
        
        // Récupérer l'emprunt
        $stmt = $pdo->prepare("SELECT * FROM emprunts WHERE id = ?");
        $stmt->execute([$id]);
        $emprunt = $stmt->fetch();
        
        if (!$emprunt) {
            return false;
        }
        
        // Mettre à jour l'emprunt
        $stmt = $pdo->prepare("UPDATE emprunts SET statut = 'perdu' WHERE id = ?");
        $stmt->execute([$id]);
        
        // Mettre à jour le statut du livre
        $stmt = $pdo->prepare("UPDATE livres SET statut = 'perdu' WHERE id = ?");
        $stmt->execute([$emprunt['livre_id']]);
        
        return true;
    }
    
    /**
     * Met à jour les statuts des emprunts en retard
     */
    public static function updateStatutsRetard() {
        global $pdo;
        $stmt = $pdo->query("
            UPDATE emprunts 
            SET statut = 'retard' 
            WHERE statut = 'en_cours' 
            AND date_retour_prevue < CURDATE()
        ");
        return $stmt;
    }
    
    /**
     * Vérifie si un utilisateur a des retards
     */
    public static function hasRetard($utilisateur_id) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM emprunts 
            WHERE utilisateur_id = ? 
            AND (statut = 'retard' OR (statut = 'en_cours' AND date_retour_prevue < CURDATE()))
        ");
        $stmt->execute([$utilisateur_id]);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Récupère les statistiques
     */
    public static function getStats() {
        global $pdo;
        $stmt = $pdo->query("
            SELECT 
                COUNT(*) as total_emprunts,
                SUM(CASE WHEN statut = 'en_cours' THEN 1 ELSE 0 END) as emprunts_en_cours,
                SUM(CASE WHEN statut = 'retard' OR (statut = 'en_cours' AND date_retour_prevue < CURDATE()) THEN 1 ELSE 0 END) as emprunts_en_retard,
                SUM(CASE WHEN statut = 'rendu' THEN 1 ELSE 0 END) as emprunts_rendus,
                SUM(CASE WHEN statut = 'perdu' THEN 1 ELSE 0 END) as emprunts_perdus
            FROM emprunts
        ");
        return $stmt->fetch();
    }
}
?>