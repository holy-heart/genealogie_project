<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Généalogie Collaborative

Une application web Laravel pour gérer des arbres généalogiques avec validation collaborative des modifications.

## Fonctionnalités principales

- **Gestion des personnes** : Création, consultation et modification des profils
- **Système de parenté** : Recherche des liens familiaux entre personnes
- **Workflow collaboratif** : Proposition et validation des modifications
- **Authentification**: Avec système d'invitation

## Structure de la base de données

![1744313387270](image/README/1744313387270.png)

Tables principales :

- `users` : Gestion des comptes utilisateurs
- `people` : Stocke les informations des personnes
- `relationships` : Gère les liens familiaux
- `modifications` : Suivi des propositions de changements
- `invitations` : Gestion des codes d'accès

## Routes API

### Authentification

- `POST /login` - Connexion utilisateur
- `POST /logout` - Déconnexion
- `GET /sign` - Page d'inscription
- `POST /checksign` - Traitement de l'inscription
- `GET /invitcode` - Page de code d'invitation
- `POST /checkinvit` - Validation du code d'invitation

### Gestion des personnes

- `GET /people` - Liste toutes les personnes
- `GET /people/{id}` - Affiche une personne spécifique
- `GET /create/{id}` - Formulaire de création (protégé)
- `POST /people` - Stocke une nouvelle personne (protégé)

### Workflow collaboratif

- `GET /proposer/{id}` - Page de proposition de modification
- `GET /saveproposition/{id}/{person}/{link}` - Sauvegarde une proposition
- `GET /valider/{p}/{p2}/{link}` - Valide une modification
- `GET /refuser/{p}/{p2}/{link}` - Rejette une modification

### Outils

- `GET /test-parentlink` - Test de la recherche de parenté

## Workflow des modifications

1. **Proposition** :

   - Un utilisateur authentifié propose un changement via `/proposer/{id}`
   - La proposition est enregistrée dans `modifications` avec statut "pending"
2. **Validation/Rejet** :

   - Un autre utilisateur peut :
     - Valider (`/valider`) → applique les changements et met à jour le statut
     - Rejeter (`/refuser`) → marque la proposition comme rejetée
3. **Historique** :

   - Toutes les modifications sont conservées pour traçabilité

## Installation

1. Cloner le dépôt
2. `composer install`
3. Créer et configurer `.env`
4. `php artisan migrate --seed`
5. `php artisan serve`

## Tests

Le endpoint `/test-parentlink` permet de tester la recherche de liens familiaux avec une fonction recursive :

- Affiche le degré de parenté
- Montre le chemin entre deux personnes
- Donne des métriques de performance

---

*Projet développé avec Laravel et MySQL*
