# Médiathèque de Versailles - Système de Gestion de Bibliothèque

Système complet de gestion de bibliothèque développé en architecture **MVC stricte** avec **PHP 7.4+** et **Bootstrap 5**.

## Fonctionnalités
- **Tableau de bord :** Statistiques en temps réel et alertes de retards.
- **Gestion du catalogue :** CRUD complet des livres, gestion des exemplaires multiples et emplacements.
- **Système d'emprunts :** Création avec vérification de disponibilité, calcul automatique des dates de retour et détection des retards (SQL DATEDIFF).
- **Gestion Utilisateurs :** Suivi des étudiants, professeurs et personnel avec historique d'emprunts.

## Stack Technique
- **Backend :** PHP 7.4+, PDO (Requêtes préparées).
- **Base de données :** MySQL/MariaDB (Transactions SQL pour l'intégrité).
- **Frontend :** Bootstrap 5.3.2, Bootstrap Icons.
- **Architecture :** MVC (Modèle-Vue-Contrôleur) avec Front Controller (`index.php`).

## Architecture de la Base de Données
Le projet repose sur 3 tables principales (`livres`, `emprunts`, `utilisateurs`) avec des contraintes d'intégrité référentielle fortes.


## Installation
1. Cloner le dépôt dans `htdocs` ou votre dossier web.
2. Importer le fichier `sql/schema.sql` dans votre base de données.
3. Configurer vos accès à la base de données dans `includes/db.php`.
4. Accéder au projet via `http://localhost/mediatheque/`.

## Évolutions prévues
- Ajout d'un système d'authentification et de gestion des rôles (Admin/Bibliothécaire).
- Notifications automatiques par email pour les retards.
- Exportation des statistiques en PDF/Excel.
