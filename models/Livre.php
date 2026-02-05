<?php
class Livre {
    
    /**
     * Récupère tous les livres
     */
    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM livres ORDER BY titre ASC");
        return $stmt->fetchAll();
    }
    
    /**
     * Recherche des livres
     */
    public static function search($keyword) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT * FROM livres 
            WHERE titre LIKE ? OR auteur LIKE ? OR isbn LIKE ?
            ORDER BY titre ASC
        ");
        $keyword = "%{$keyword}%";
        $stmt->execute([$keyword, $keyword, $keyword]);
        return $stmt->fetchAll();
    }
    
    /**
     * Récupère un livre par son ID
     */
    public static function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM livres WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Crée un nouveau livre
     */
    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO livres (isbn, titre, auteur, editeur, annee_publication, 
                               categorie, nombre_exemplaires, exemplaires_disponibles, 
                               emplacement, statut) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'disponible')
        ");
        return $stmt->execute([
            $data['isbn'],
            $data['titre'],
            $data['auteur'],
            $data['editeur'],
            $data['annee_publication'],
            $data['categorie'],
            $data['nombre_exemplaires'],
            $data['nombre_exemplaires'], // exemplaires_disponibles = nombre_exemplaires
            $data['emplacement']
        ]);
    }
    
    /**
     * Met à jour un livre
     */
    public static function update($id, $data) {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE livres 
            SET isbn = ?, titre = ?, auteur = ?, editeur = ?, 
                annee_publication = ?, categorie = ?, nombre_exemplaires = ?, 
                exemplaires_disponibles = ?, emplacement = ?, statut = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['isbn'],
            $data['titre'],
            $data['auteur'],
            $data['editeur'],
            $data['annee_publication'],
            $data['categorie'],
            $data['nombre_exemplaires'],
            $data['exemplaires_disponibles'],
            $data['emplacement'],
            $data['statut'],
            $id
        ]);
    }
    
    /**
     * Supprime un livre
     */
    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM livres WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    /**
     * Récupère les livres disponibles
     */
    public static function getAvailable() {
        global $pdo;
        $stmt = $pdo->query("
            SELECT * FROM livres 
            WHERE exemplaires_disponibles > 0 AND statut = 'disponible'
            ORDER BY titre ASC
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Décrémente les exemplaires disponibles
     */
    public static function decrementDisponibles($id) {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE livres 
            SET exemplaires_disponibles = exemplaires_disponibles - 1,
                statut = CASE 
                    WHEN exemplaires_disponibles - 1 <= 0 THEN 'emprunte'
                    ELSE statut
                END
            WHERE id = ? AND exemplaires_disponibles > 0
        ");
        return $stmt->execute([$id]);
    }
    
    /**
     * Incrémente les exemplaires disponibles
     */
    public static function incrementDisponibles($id) {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE livres 
            SET exemplaires_disponibles = exemplaires_disponibles + 1,
                statut = 'disponible'
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }
    
    /**
     * Récupère les statistiques
     */
    public static function getStats() {
        global $pdo;
        $stmt = $pdo->query("
            SELECT 
                COUNT(*) as total_livres,
                SUM(nombre_exemplaires) as total_exemplaires,
                SUM(exemplaires_disponibles) as exemplaires_disponibles,
                SUM(CASE WHEN statut = 'emprunte' THEN 1 ELSE 0 END) as livres_empruntes,
                SUM(CASE WHEN statut = 'perdu' THEN 1 ELSE 0 END) as livres_perdus
            FROM livres
        ");
        return $stmt->fetch();
    }
}
?>