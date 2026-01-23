
## Architecture backend du projet

app/
├── Models/
│   ├── Utilisateur
│   ├── Role
│   ├── Don
│   ├── DemandeDon
│   ├── PieceJointeDemande
│   ├── AnnonceAssociation
│   ├── Notification
│   ├── Conversation
│   ├── Message
│   └── Securite/
│       ├── CompteOAuth
│       ├── TokenActualisation
│       ├── TokenAccesBlacklist
│       ├── TokenVerification
│       ├── TokenReinitialisationMdp
│       └── HistoriqueConnexion
│
├── Http/Controllers/
│   ├── Auth/
│   ├── FeedController
│   ├── ProfilController
│   ├── DonController
│   ├── DemandeDonController
│   ├── AnnonceAssociationController
│   ├── ConversationController
│   ├── MessageController
│   ├── NotificationController
│   └── Admin/
│       ├── DashboardController
│       ├── ModerationController
│       └── UtilisateurController
│
├── Http/Requests/
│   ├── Auth/
│   ├── Don/
│   ├── DemandeDon/
│   ├── Annonce/
│   └── Message/
│
├── Policies/
│   ├── DonPolicy
│   ├── DemandeDonPolicy
│   ├── AnnonceAssociationPolicy
│   ├── ConversationPolicy
│   └── MessagePolicy
│
├── Services/
│   ├── FeedService
│   ├── DonService
│   ├── DemandeDonService
│   ├── MessagerieService
│   └── ModerationService
│
├── Observers/
│   ├── DonObserver
│   └── DemandeDonObserver
│
├── Notifications/
│   ├── PublicationValideeNotification
│   ├── NouvelleDemandeNotification
│   └── NouveauMessageNotification
│
└── Middleware/
    ├── CheckRole
    └── CheckStatutCompte
________________________________________
## 3️⃣ Architecture frontend (Blade – MVC)

Structure des vues
resources/views/
├── layouts/
│   ├── app.blade.php
│   ├── header.blade.php
│   └── footer.blade.php
│
├── feed/
│   └── index.blade.php
│
├── profil/
│   ├── show.blade.php
│   └── edit.blade.php
│
├── compte/
│   └── dashboard.blade.php
│
├── don/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── show.blade.php
│
├── demande_don/
│   ├── create.blade.php
│   └── index.blade.php
│
├── annonce_association/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── show.blade.php
│
├── messagerie/
│   ├── conversations.blade.php
│   └── messages.blade.php
│
├── notification/
│   └── index.blade.php
│
├── admin/
│   ├── dashboard.blade.php
│   ├── moderation.blade.php
│   └── utilisateurs.blade.php
│
└── auth/
    ├── login.blade.php
    ├── register.blade.php
    └── reset.blade.php
