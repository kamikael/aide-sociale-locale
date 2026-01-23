# Aide Sociale Locale

## 🌍 Présentation

**Aide Sociale Locale** est une application web conçue pour faciliter les dons locaux et mettre en relation :

- Des **donateurs** (particuliers ou organisations)  
- Des **bénéficiaires** dans le besoin  
- Des **associations locales**  
- Un **administrateur** pour la modération et gestion globale  

L'objectif est de créer un **MVP fonctionnel** permettant de publier des dons, faire des demandes, consulter des annonces, envoyer des messages et gérer les utilisateurs, dans un **monolithe Laravel**.

---

## 🏗️ Structure du projet

Le projet est organisé selon l'architecture **MVC Laravel** :

### Backend (`app/`)

- **Models** : entités métier (Don, DemandeDon, AnnonceAssociation, Utilisateur, Role, Notification, Conversation, Message, sécurité…)  
- **Controllers** : orchestration des fonctionnalités par module  
- **Requests** : validations des formulaires  
- **Policies** : autorisations par rôle  
- **Services** : logique métier principale  
- **Observers** : actions automatiques sur modèles  
- **Notifications** : notifications internes  
- **Middleware** : gestion de rôles et statuts

### Frontend (`resources/views/`)

- **layouts/** : layout principal, header et footer  
- **feed/** : feed central (timeline)  
- **profil/** : profils utilisateurs  
- **compte/** : dashboard privé  
- **don/** : pages de dons (index, création, détails)  
- **demande_don/** : pages de demandes de dons  
- **annonce_association/** : annonces associations  
- **messagerie/** : conversations et messages privés  
- **notification/** : notifications internes  
- **admin/** : interface administration  
- **auth/** : login, register, reset password  

> Tous les fichiers sont actuellement créés, prêts à être codés selon le planning.

---

## 🚀 Installation

1. Cloner le projet :

```bash
git clone https://github.com/ton-repo/aide-sociale-locale.git
cd aide-sociale-locale
Installer les dépendances Laravel :

composer install


Copier le fichier .env et configurer la base de données :

copy .env.example .env
php artisan key:generate


Migrer la base de données :

php artisan migrate


Lancer le serveur local :

php artisan serve


Le projet sera disponible sur : http://127.0.0.1:8000