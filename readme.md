# Gestionnaire de listes de courses
Gestionnaire minimaliste de listes de courses en PHP/SQL (moteur SQLite). À utiliser sur un réseau local, car ne fournit pas d'espace utilisateur.

Au départ développé pour un usage personnel, je partage le code source ici. C'est programmé rapidement et sans grand soin. Je n'assure pas le suivi du code, qui n'est d'ailleurs pas documenté correctement.

## Licence
Le projet est distribué sous licence [GPLv3](https://www.gnu.org/licenses/gpl-3.0.fr.html).

## Installation
Le code est basé sur le framework [CodeIgniter](https://codeigniter.com/), version 3.1.

Clonez le dépôt sur votre serveur web et modifiez le fichier application/config/database.php avec les données de configuration de votre base de données.

Initialisez les schémas dans la base en exécutant les requêtes de schema_db.sql, puis supprimez le fichier.

La page d'entrée vers l'application est /index.php/rayons/lister.

## Contributions
J'accepte volontiers toutes les contributions, mais comme précisé plus haut, je ne m'engage pas à fournir une documentation détaillée pour le code, ni d'ailleurs à proposer un code très propre.

Si vous souhaitez proposer une pull request, ne travailler que sur la branche dev, la branche master contenant le dernier code stable convenablement testé.

## Fonctionnalités prévues
Sur une recette, saisie du nombre de personnes, ce qui se répercuterait sur la génération des listes de courses.

