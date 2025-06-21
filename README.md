# Projet Annonces Classées

Ce projet est une application Laravel permettant de gérer les petites annonces avec système d'authentification, modération et gestion des images.

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- Node.js et NPM
- MySQL

## Installation

1. Cloner le projet
```bash
git clone <url-du-projet>
cd <nom-du-projet>
```

2. Installer les dépendances PHP
```bash
composer install
```

3. Installer les dépendances JavaScript
```bash
npm install
npm run build
```

4. Configuration de l'environnement
```bash
# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

5. Configurer la base de données dans le fichier .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_votre_base
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

6. Créer les tables de la base de données
```bash
php artisan migrate
```

7. Configuration du stockage des images
```bash
# Créer le lien symbolique pour le stockage public
php artisan storage:link

# Créer le répertoire pour les images des annonces
mkdir -p storage/app/public/ads

# Définir les permissions appropriées
chmod -R 775 storage/app/public/ads
```

## Structure des dossiers pour les images

Les images des annonces sont stockées selon la structure suivante :
- Chemin physique : `storage/app/public/ads/`
- URL d'accès : `/storage/ads/`

## Démarrage du serveur de développement

1. Lancer le serveur Laravel
```bash
php artisan serve
```

2. Lancer la compilation des assets (en mode développement)
```bash
npm run dev
```

## Fonctionnalités principales

- Authentification des utilisateurs
- Création, modification et suppression d'annonces
- Upload d'images pour les annonces
- Modération des annonces par les administrateurs
- Limitation du nombre d'annonces par utilisateur (rate limiting)

## Rôles utilisateurs

- Utilisateur standard : peut créer et gérer ses propres annonces
- Administrateur : peut modérer toutes les annonces et gérer les utilisateurs

## Maintenance

Pour vider les caches de l'application :
```bash
php artisan optimize:clear
```

## Sécurité

- Les images sont stockées de manière sécurisée via le système de stockage de Laravel
- Protection CSRF sur tous les formulaires
- Validation des données côté serveur
- Rate limiting pour prévenir les abus

## Contribution

1. Créer une branche pour votre fonctionnalité
2. Commiter vos changements
3. Pousser vers la branche
4. Créer une Pull Request

## Support

Pour toute question ou problème, veuillez ouvrir une issue dans le dépôt du projet.
