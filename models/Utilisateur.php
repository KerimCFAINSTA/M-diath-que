<?php
class Utilisateur {
    
    /**
     * Récupère tous les utilisateurs
     */
    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM utilisateurs ORDER BY nom ASC, prenom ASC");
        return $stmt->fetchAll();
    }
    
    /**
     * Recherche des utilisateurs
     */
    public static function search($keyword) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT * FROM utilisateurs 
            WHERE nom LIKE ? OR prenom LIKE ? OR email LIKE ? OR nom_ecole LIKE ?
            ORDER BY nom ASC, prenom ASC
        ");
        $keyword = "%{$keyword}%";
        $stmt->execute([$keyword, $keyword, $keyword, $keyword]);
        return $stmt->fetchAll();
    }
    
    /**
     * Récupère un utilisateur par son ID
     */
    public static function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Crée un nouvel utilisateur
     */
    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO utilisateurs (nom, prenom, email, telephone, 
                                     type_utilisateur, nom_ecole, actif) 
            VALUES (?, ?, ?, ?, ?, ?, 1)
        ");
        return $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['telephone'],
            $data['type_utilisateur'],
            $data['nom_ecole'] ?? null
        ]);
    }
    
    /**
     * Met à jour un utilisateur
     */
    public static function update($id, $data) {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE utilisateurs 
            SET nom = ?, prenom = ?, email = ?, telephone = ?, 
                type_utilisateur = ?, nom_ecole = ?, actif = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['telephone'],
            $data['type_utilisateur'],
            $data['nom_ecole'] ?? null,
            $data['actif'],
            $id
        ]);
    }
    
    /**
     * Supprime un utilisateur
     */
    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    /**
     * Récupère les utilisateurs actifs
     */
    public static function getActifs() {
        global $pdo;
        $stmt = $pdo->query("
            SELECT * FROM utilisateurs 
            WHERE actif = 1 
            ORDER BY nom ASC, prenom ASC
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Récupère les utilisateurs par type
     */
    public static function getByType($type) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT * FROM utilisateurs 
            WHERE type_utilisateur = ?
            ORDER BY nom ASC, prenom ASC
        ");
        $stmt->execute([$type]);
        return $stmt->fetchAll();
    }
    
    /**
     * Vérifie si l'email existe déjà
     */
    public static function emailExists($email, $excludeId = null) {
        global $pdo;
        if ($excludeId) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ? AND id != ?");
            $stmt->execute([$email, $excludeId]);
        } else {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
        }
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Récupère les statistiques
     */
    public static function getStats() {
        global $pdo;
        $stmt = $pdo->query("
            SELECT 
                COUNT(*) as total_utilisateurs,
                SUM(CASE WHEN type_utilisateur = 'public' THEN 1 ELSE 0 END) as total_public,
                SUM(CASE WHEN type_utilisateur = 'ecole' THEN 1 ELSE 0 END) as total_ecole,
                SUM(CASE WHEN actif = 1 THEN 1 ELSE 0 END) as utilisateurs_actifs
            FROM utilisateurs
        ");
        return $stmt->fetch();
    }
}
?>