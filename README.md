# 📚 Médiathèque de Versailles - Système de Gestion de Bibliothèque

[cite_start]Système complet de gestion de bibliothèque développé en architecture **MVC stricte** avec **PHP 7.4+** et **Bootstrap 5**[cite: 7, 54].

## 🚀 Fonctionnalités
- [cite_start]**Tableau de bord :** Statistiques en temps réel et alertes de retards[cite: 25, 26].
- [cite_start]**Gestion du catalogue :** CRUD complet des livres, gestion des exemplaires multiples et emplacements[cite: 31, 33, 36].
- [cite_start]**Système d'emprunts :** Création avec vérification de disponibilité, calcul automatique des dates de retour et détection des retards (SQL DATEDIFF)[cite: 39, 40, 42].
- [cite_start]**Gestion Utilisateurs :** Suivi des étudiants, professeurs et personnel avec historique d'emprunts[cite: 48, 51].

## 🛠️ Stack Technique
- [cite_start]**Backend :** PHP 7.4+, PDO (Requêtes préparées)[cite: 54, 55, 56].
- [cite_start]**Base de données :** MySQL/MariaDB (Transactions SQL pour l'intégrité)[cite: 59, 151].
- [cite_start]**Frontend :** Bootstrap 5.3.2, Bootstrap Icons[cite: 65, 66].
- [cite_start]**Architecture :** MVC (Modèle-Vue-Contrôleur) avec Front Controller (`index.php`)[cite: 70, 71].

## 📊 Architecture de la Base de Données
[cite_start]Le projet repose sur 3 tables principales (`livres`, `emprunts`, `utilisateurs`) avec des contraintes d'intégrité référentielle fortes[cite: 60, 61, 145].


## 🔧 Installation
1. [cite_start]Cloner le dépôt dans `htdocs` ou votre dossier web[cite: 205].
2. [cite_start]Importer le fichier `sql/schema.sql` dans votre base de données[cite: 207].
3. [cite_start]Configurer vos accès à la base de données dans `includes/db.php`[cite: 210].
4. [cite_start]Accéder au projet via `http://localhost/mediatheque/`[cite: 213].

## 📈 Évolutions prévues
- [cite_start]Ajout d'un système d'authentification et de gestion des rôles (Admin/Bibliothécaire)[cite: 259, 260].
- [cite_start]Notifications automatiques par email pour les retards[cite: 264].
- [cite_start]Exportation des statistiques en PDF/Excel[cite: 272].
