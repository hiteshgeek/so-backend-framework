<?php

/**
 * French Notification Templates
 *
 * Notification message templates for email, database, and push notifications.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Welcome Notifications
    |--------------------------------------------------------------------------
    */

    'welcome' => [
        'title' => 'Bienvenue dans le système!',
        'message' => 'Bonjour :name, bienvenue dans notre système ERP! Nous sommes ravis de vous avoir à bord.',
        'action' => 'Aller au tableau de bord',
    ],

    /*
    |--------------------------------------------------------------------------
    | Order Notifications
    |--------------------------------------------------------------------------
    */

    'order' => [
        'created' => [
            'title' => 'Commande créée',
            'message' => 'Votre commande #:order_id a été créée avec succès.',
            'action' => 'Voir la commande',
        ],
        'updated' => [
            'title' => 'Commande mise à jour',
            'message' => 'Votre commande #:order_id a été mise à jour.',
            'action' => 'Voir la commande',
        ],
        'shipped' => [
            'title' => 'Commande expédiée',
            'message' => 'Votre commande #:order_id a été expédiée. Numéro de suivi: :tracking_number',
            'action' => 'Suivre la commande',
        ],
        'delivered' => [
            'title' => 'Commande livrée',
            'message' => 'Votre commande #:order_id a été livrée avec succès.',
            'action' => 'Voir la commande',
        ],
        'cancelled' => [
            'title' => 'Commande annulée',
            'message' => 'Votre commande #:order_id a été annulée.',
            'action' => 'Voir la commande',
        ],
        'approval_required' => [
            'title' => 'Approbation de commande requise',
            'message' => 'La commande #:order_id nécessite votre approbation.',
            'action' => 'Réviser la commande',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Notifications
    |--------------------------------------------------------------------------
    */

    'user' => [
        'account_created' => [
            'title' => 'Compte créé',
            'message' => 'Votre compte a été créé avec succès. Bienvenue!',
            'action' => 'Se connecter',
        ],
        'password_changed' => [
            'title' => 'Mot de passe changé',
            'message' => 'Votre mot de passe a été changé avec succès.',
            'action' => null,
        ],
        'profile_updated' => [
            'title' => 'Profil mis à jour',
            'message' => 'Les informations de votre profil ont été mises à jour avec succès.',
            'action' => 'Voir le profil',
        ],
        'role_changed' => [
            'title' => 'Rôle changé',
            'message' => 'Votre rôle a été changé en :role.',
            'action' => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Notifications
    |--------------------------------------------------------------------------
    */

    'payment' => [
        'received' => [
            'title' => 'Paiement reçu',
            'message' => 'Votre paiement de :amount a été reçu avec succès.',
            'action' => 'Voir le reçu',
        ],
        'failed' => [
            'title' => 'Paiement échoué',
            'message' => 'Votre paiement de :amount a échoué. Veuillez réessayer.',
            'action' => 'Réessayer le paiement',
        ],
        'refunded' => [
            'title' => 'Paiement remboursé',
            'message' => 'Votre paiement de :amount a été remboursé.',
            'action' => 'Voir les détails',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | System Notifications
    |--------------------------------------------------------------------------
    */

    'system' => [
        'maintenance' => [
            'title' => 'Maintenance planifiée',
            'message' => 'Le système sera en maintenance de :start_time à :end_time.',
            'action' => null,
        ],
        'update' => [
            'title' => 'Mise à jour du système',
            'message' => 'Le système a été mis à jour vers la version :version.',
            'action' => 'Voir les modifications',
        ],
        'backup_complete' => [
            'title' => 'Sauvegarde terminée',
            'message' => 'La sauvegarde du système a été terminée avec succès.',
            'action' => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Task/Activity Notifications
    |--------------------------------------------------------------------------
    */

    'task' => [
        'assigned' => [
            'title' => 'Tâche assignée',
            'message' => 'Une nouvelle tâche vous a été assignée: :task_name',
            'action' => 'Voir la tâche',
        ],
        'completed' => [
            'title' => 'Tâche terminée',
            'message' => 'La tâche :task_name a été terminée.',
            'action' => 'Voir la tâche',
        ],
        'due_soon' => [
            'title' => 'Tâche bientôt échue',
            'message' => 'La tâche :task_name est échue dans :hours heures.',
            'action' => 'Voir la tâche',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | General Notification Templates
    |--------------------------------------------------------------------------
    */

    'general' => [
        'info' => [
            'title' => 'Information',
            'message' => ':message',
            'action' => 'En savoir plus',
        ],
        'warning' => [
            'title' => 'Avertissement',
            'message' => ':message',
            'action' => 'Voir les détails',
        ],
        'error' => [
            'title' => 'Erreur',
            'message' => ':message',
            'action' => 'Signaler le problème',
        ],
        'success' => [
            'title' => 'Succès',
            'message' => ':message',
            'action' => null,
        ],
    ],
];
