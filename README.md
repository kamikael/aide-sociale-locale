# 🎁 Application de Dons – Laravel Monolithe (Mobile Money)

Application web de dons et de cagnottes solidaires, développée en **Laravel 10+**, sans authentification utilisateur côté public, intégrant des **paiements Mobile Money** (Afrique de l’Ouest).

Le projet suit une **architecture monolithique moderne**, orientée domaines (DDD léger), prête pour la montée en charge et l’évolution API / mobile.

---

## 🧱 Stack Technique

- **Framework** : Laravel 10+
- **Architecture** : Monolithe (DDD léger)
- **Rendu** : Blade (SPA-ready)
- **Base de données** : MySQL / MariaDB
- **Paiement** : Mobile Money (MTN, Moov, Orange via agrégateur)
- **Queue (optionnel)** : Redis
- **Stockage fichiers** : Local (`storage`) → évolutif vers S3

---

## 📁 Structure du projet (vue d’ensemble)

app/
├── Domain/ # Logique métier par domaine
├── Http/ # Controllers, Requests, Middleware
├── Services/ # Services transverses
├── Events/Listeners/Jobs
├── Policies
resources/
├── views/ # Vues Blade (public / admin)
routes/
├── web.php
├── admin.php
├── payment.php


👉 Chaque domaine métier est isolé pour garantir **lisibilité, maintenabilité et travail en équipe**.

---

## 👥 Organisation de l’équipe

### Backend
- **Kami**
  - Publication
  - Validation
  - Audit & Logs

- **Neal (backend)**
  - Paiement Mobile Money
  - Transactions
  - Sécurité des callbacks

### Frontend (Blade)
- **Neal (frontend)**
  - Vues publiques (landing, posts, dons)

- **Maëlle**
  - Vues administration (dashboard, validation, paiements, audit)

---

## 🌱 Convention Git (OBLIGATOIRE)

### Branches de travail

| Développeur | Rôle | Nom de la feature |
|------------|------|------------------|
| Kami | Backend | `feature/publication-validation` |
| Neal | Backend | `feature/mobile-money-payment` |
| Neal | Frontend | `feature/public-views` |
| Maëlle | Frontend | `feature/admin-views` |

### Règles
- ❌ Aucun push direct sur `main`
- ✅ 1 feature = 1 responsabilité
- ✅ Pull Request obligatoire
- ✅ Revue de code avant merge

---

## 🧩 Domaines métiers

### Publication
- Création de post (sans compte)
- Gestion des médias
- Données privées séparées

### Validation
- Approbation / rejet / révocation
- Décisions administrateur
- Événements métier

### Paiement
- Initialisation Mobile Money
- Callbacks sécurisés
- Gestion des transactions

### Audit
- Journalisation des décisions admin
- Historique immuable

---

## 🖥️ Vues (Blade)

### Public
- Accueil
- Création de post
- Détail post
- Don Mobile Money
- Statut paiement

### Administration
- Auth admin
- Dashboard
- Validation des posts
- Suivi des paiements
- Logs & audit

---

## 🔐 Sécurité (points clés)

- Validation via `FormRequest`
- Rate limiting public
- Téléphone normalisé (E.164)
- Upload média sécurisé (taille + MIME)
- Callbacks paiement signés + idempotents
- Aucune donnée bancaire stockée

---

## 📦 Packages principaux

```bash
composer require guzzlehttp/guzzle
composer require intervention/image
composer require spatie/laravel-activitylog
composer require predis/predis
composer require mews/captcha
🚀 Installation du projet
git clone <repo>
cd project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
📜 Logs & Monitoring
Logs journaliers (daily)

Channel dédié payment

Channel dédié admin_actions

Aucune donnée sensible en clair

🔮 Scalabilité (prévue)
Sans refonte :

Passage stockage → S3

Queue Redis

Ajout providers paiement

API publique

Application mobile

📌 Règles importantes
❗ Pas de logique métier dans les controllers

❗ Pas d’accès direct DB hors Repository

❗ Pas d’exposition des données privées côté public

❗ Tout paiement doit être idempotent

✅ Objectif du projet
Fournir une plateforme de dons fiable, sécurisée et adaptée au contexte africain, tout en restant simple à maintenir et à faire évoluer.

Bon développement à tous 🚀