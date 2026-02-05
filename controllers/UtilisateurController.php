<?php
/**
 * Controller Utilisateur
 */

require_once 'models/Utilisateur.php';

class UtilisateurController {
    
    /**
     * Liste tous les utilisateurs
     */
    public static function index() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        
        if (!empty($search)) {
            $utilisateurs = Utilisateur::search($search);
        } else if ($filter !== 'all') {
            $utilisateurs = Utilisateur::getByType($filter);
        } else {
            $utilisateurs = Utilisateur::getAll();
        }
        
        include 'views/utilisateurs/index.php';
    }
    
    /**
     * Affiche le formulaire de création
     */
    public static function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier si l'email existe déjà
            if (Utilisateur::emailExists($_POST['email'])) {
                $error = "Cet email est déjà utilisé.";
            } else {
                $data = [
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'email' => $_POST['email'],
                    'telephone' => $_POST['telephone'],
                    'type_utilisateur' => $_POST['type_utilisateur'],
                    'nom_ecole' => $_POST['nom_ecole'] ?? null
                ];
                
                if (Utilisateur::create($data)) {
                    header("Location: index.php?page=utilisateurs&success=1");
                    exit();
                } else {
                    $error = "Erreur lors de l'ajout de l'utilisateur.";
                }
            }
        }
        
        include 'views/utilisateurs/create.php';
    }
    
    /**
     * Affiche le formulaire de modification
     */
    public static function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if (!$id) {
            header("Location: index.php?page=utilisateurs");
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier si l'email existe déjà (sauf pour cet utilisateur)
            if (Utilisateur::emailExists($_POST['email'], $id)) {
                $error = "Cet email est déjà utilisé par un autre utilisateur.";
            } else {
                $data = [
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'email' => $_POST['email'],
                    'telephone' => $_POST['telephone'],
                    'type_utilisateur' => $_POST['type_utilisateur'],
                    'nom_ecole' => $_POST['nom_ecole'] ?? null,
                    'actif' => isset($_POST['actif']) ? 1 : 0
                ];
                
                if (Utilisateur::update($id, $data)) {
                    header("Location: index.php?page=utilisateurs&success=1");
                    exit();
                } else {
                    $error = "Erreur lors de la modification de l'utilisateur.";
                }
            }
        }
        
        $utilisateur = Utilisateur::getById($id);
        
        if (!$utilisateur) {
            header("Location: index.php?page=utilisateurs");
            exit();
        }
        
        include 'views/utilisateurs/edit.php';
    }
    
    /**
     * Supprime un utilisateur
     */
    public static function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if ($id && Utilisateur::delete($id)) {
            header("Location: index.php?page=utilisateurs&success=1");
        } else {
            header("Location: index.php?page=utilisateurs&error=1");
        }
        exit();
    }
}
?>