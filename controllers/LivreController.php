<?php
/**
 * Controller Livre
 */

require_once 'models/Livre.php';

class LivreController {
    
    /**
     * Liste tous les livres
     */
    public static function index() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        
        if (!empty($search)) {
            $livres = Livre::search($search);
        } else {
            $livres = Livre::getAll();
        }
        
        include 'views/livres/index.php';
    }
    
    /**
     * Affiche le formulaire de création
     */
    public static function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'isbn' => $_POST['isbn'],
                'titre' => $_POST['titre'],
                'auteur' => $_POST['auteur'],
                'editeur' => $_POST['editeur'],
                'annee_publication' => $_POST['annee_publication'],
                'categorie' => $_POST['categorie'],
                'nombre_exemplaires' => $_POST['nombre_exemplaires'],
                'emplacement' => $_POST['emplacement']
            ];
            
            if (Livre::create($data)) {
                header("Location: index.php?page=livres&success=1");
                exit();
            } else {
                $error = "Erreur lors de l'ajout du livre.";
            }
        }
        
        include 'views/livres/create.php';
    }
    
    /**
     * Affiche le formulaire de modification
     */
    public static function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if (!$id) {
            header("Location: index.php?page=livres");
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'isbn' => $_POST['isbn'],
                'titre' => $_POST['titre'],
                'auteur' => $_POST['auteur'],
                'editeur' => $_POST['editeur'],
                'annee_publication' => $_POST['annee_publication'],
                'categorie' => $_POST['categorie'],
                'nombre_exemplaires' => $_POST['nombre_exemplaires'],
                'exemplaires_disponibles' => $_POST['exemplaires_disponibles'],
                'emplacement' => $_POST['emplacement'],
                'statut' => $_POST['statut']
            ];
            
            if (Livre::update($id, $data)) {
                header("Location: index.php?page=livres&success=1");
                exit();
            } else {
                $error = "Erreur lors de la modification du livre.";
            }
        }
        
        $livre = Livre::getById($id);
        
        if (!$livre) {
            header("Location: index.php?page=livres");
            exit();
        }
        
        include 'views/livres/edit.php';
    }
    
    /**
     * Supprime un livre
     */
    public static function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if ($id && Livre::delete($id)) {
            header("Location: index.php?page=livres&success=1");
        } else {
            header("Location: index.php?page=livres&error=1");
        }
        exit();
    }
}
?>