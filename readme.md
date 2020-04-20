# Gestionnaire de listes de courses
Gestionnaire minimaliste de listes de courses en PHP/SQL (moteur SQLite). À utiliser localement, car ne fournit pas d'espace utilisateur.

Au départ développé pour un usage personnel, je partage le code source ici. C'est programmé rapidement et sans grand soin. Je n'assure pas le suivi du code, qui n'est d'ailleurs pas documenté correctement.

## Licence
Le projet est distribué sous licence [GPLv3](https://www.gnu.org/licenses/gpl-3.0.fr.html).

## Installation
Le code est basé sur le framework [CodeIgniter](https://codeigniter.com/), version 3.1.

Clonez le dépôt sur votre serveur web et modifiez le fichier application/config/database.php avec les données de configuration de votre base de données.

Initialisez les schémas dans la base en exécutant les requêtes de schema_db.sql, puis supprimez le fichier.

## Fonctionnalités prévues
Sur une recette, saisie du nombre de personnes, ce qui se répercuterait sur la génération des listes de courses.
