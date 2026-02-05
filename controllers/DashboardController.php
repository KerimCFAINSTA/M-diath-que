<?php
/**
 * Controller Dashboard
 */

require_once 'models/Livre.php';
require_once 'models/Utilisateur.php';
require_once 'models/Emprunt.php';

// Mettre à jour les statuts des emprunts en retard
Emprunt::updateStatutsRetard();

// Récupérer les statistiques
$statsLivres = Livre::getStats();
$statsUtilisateurs = Utilisateur::getStats();
$statsEmprunts = Emprunt::getStats();

// Récupérer les emprunts en retard
$empruntsRetard = Emprunt::getEnRetard();

// Récupérer les emprunts en cours
$empruntsEnCours = Emprunt::getEnCours();

// Charger la vue
include 'views/dashboard/index.php';
?>