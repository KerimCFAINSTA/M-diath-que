<?php
/**
 * Controller Emprunt
 */

require_once 'models/Emprunt.php';
require_once 'models/Livre.php';
require_once 'models/Utilisateur.php';

class EmpruntController {
    
    /**
     * Liste tous les emprunts
     */
    public static function index() {
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        
        switch ($filter) {
            case 'en_cours':
                $emprunts = Emprunt::getEnCours();
                break;
            case 'en_retard':
                $emprunts = Emprunt::getEnRetard();
                break;
            default:
                $emprunts = Emprunt::getAll();
                break;
        }
        
        include 'views/emprunts/index.php';
    }
    
    /**
     * Affiche le formulaire de création d'emprunt
     */
    public static function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier si l'utilisateur a des retards
            if (Emprunt::hasRetard($_POST['utilisateur_id'])) {
                $error = "Cet utilisateur a des emprunts en retard. Impossible de créer un nouvel emprunt.";
            } else {
                $data = [
                    'livre_id' => $_POST['livre_id'],
                    'utilisateur_id' => $_POST['utilisateur_id'],
                    'date_retour_prevue' => $_POST['date_retour_prevue'],
                    'commentaire' => $_POST['commentaire'] ?? ''
                ];
                
                if (Emprunt::create($data)) {
                    header("Location: index.php?page=emprunts&success=1");
                    exit();
                } else {
                    $error = "Erreur lors de la création de l'emprunt. Vérifiez la disponibilité du livre.";
                }
            }
        }
        
        // Récupérer les livres disponibles et les utilisateurs actifs
        $livresDisponibles = Livre::getAvailable();
        $utilisateursActifs = Utilisateur::getActifs();
        
        include 'views/emprunts/create.php';
    }
    
    /**
     * Enregistre le retour d'un livre
     */
    public static function retourner() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if ($id && Emprunt::retourner($id)) {
            header("Location: index.php?page=emprunts&success=1");
        } else {
            header("Location: index.php?page=emprunts&error=1");
        }
        exit();
    }
    
    /**
     * Marque un emprunt comme perdu
     */
    public static function perdu() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if ($id && Emprunt::marquerPerdu($id)) {
            header("Location: index.php?page=emprunts&success=1");
        } else {
            header("Location: index.php?page=emprunts&error=1");
        }
        exit();
    }
}
?>