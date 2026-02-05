<?php
/**
 * Point d'entrée unique - Médiathèque de Versailles
 * Router MVC simple et efficace
 */

// Connexion à la base de données
require_once 'includes/db.php';

// Récupérer la page demandée
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Router vers la bonne page
switch ($page) {
    // Dashboard
    case 'dashboard':
        require 'controllers/DashboardController.php';
        break;
    
    // Livres
    case 'livres':
        require 'controllers/LivreController.php';
        LivreController::index();
        break;
    
    case 'livre_create':
        require 'controllers/LivreController.php';
        LivreController::create();
        break;
    
    case 'livre_edit':
        require 'controllers/LivreController.php';
        LivreController::edit();
        break;
    
    case 'livre_delete':
        require 'controllers/LivreController.php';
        LivreController::delete();
        break;
    
    // Emprunts
    case 'emprunts':
        require 'controllers/EmpruntController.php';
        EmpruntController::index();
        break;
    
    case 'emprunt_create':
        require 'controllers/EmpruntController.php';
        EmpruntController::create();
        break;
    
    case 'emprunt_retour':
        require 'controllers/EmpruntController.php';
        EmpruntController::retourner();
        break;
    
    case 'emprunt_perdu':
        require 'controllers/EmpruntController.php';
        EmpruntController::perdu();
        break;
    
    // Utilisateurs
    case 'utilisateurs':
        require 'controllers/UtilisateurController.php';
        UtilisateurController::index();
        break;
    
    case 'utilisateur_create':
        require 'controllers/UtilisateurController.php';
        UtilisateurController::create();
        break;
    
    case 'utilisateur_edit':
        require 'controllers/UtilisateurController.php';
        UtilisateurController::edit();
        break;
    
    case 'utilisateur_delete':
        require 'controllers/UtilisateurController.php';
        UtilisateurController::delete();
        break;
    
    // Page par défaut
    default:
        require 'controllers/DashboardController.php';
        break;
}
?>