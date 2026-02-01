<?php

/**
 * French Authentication Messages
 *
 * Authentication and authorization related messages for API responses.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    */

    // Login
    'login_success' => 'Connexion réussie!',
    'login_failed' => 'Email ou mot de passe invalide.',
    'invalid_credentials' => 'Identifiants invalides.',

    // Registration
    'registration_success' => 'Compte créé avec succès!',
    'registration_failed' => 'L\'inscription a échoué. Veuillez réessayer.',

    // Logout
    'logout_success' => 'Déconnexion réussie.',

    // Password Reset
    'password_reset_sent' => 'Lien de réinitialisation du mot de passe envoyé à votre e-mail.',
    'password_reset_success' => 'Mot de passe réinitialisé avec succès! Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.',
    'password_reset_failed' => 'La réinitialisation du mot de passe a échoué. Veuillez réessayer.',
    'password_reset_token_invalid' => 'Jeton de réinitialisation du mot de passe invalide ou expiré.',
    'password_reset_token_expired' => 'Le jeton de réinitialisation du mot de passe a expiré.',

    // Password Change
    'password_change_success' => 'Mot de passe changé avec succès.',
    'password_change_failed' => 'Le mot de passe actuel est incorrect.',

    // Authorization
    'unauthorized' => 'Vous n\'êtes pas autorisé à accéder à cette ressource.',
    'unauthenticated' => 'Vous devez être connecté pour accéder à cette ressource.',
    'access_denied' => 'Accès refusé.',
    'forbidden' => 'Cette action est interdite.',

    // Token
    'token_invalid' => 'Jeton d\'authentification invalide.',
    'token_expired' => 'Le jeton d\'authentification a expiré.',
    'token_missing' => 'Le jeton d\'authentification est manquant.',
    'token_revoked' => 'Le jeton d\'authentification a été révoqué.',

    // Account Status
    'account_inactive' => 'Votre compte est inactif. Veuillez contacter le support.',
    'account_suspended' => 'Votre compte a été suspendu.',
    'account_deleted' => 'Votre compte a été supprimé.',

    // Email Verification
    'email_verification_sent' => 'E-mail de vérification envoyé.',
    'email_verified' => 'E-mail vérifié avec succès.',
    'email_not_verified' => 'L\'adresse e-mail n\'est pas vérifiée.',
    'email_already_verified' => 'L\'adresse e-mail est déjà vérifiée.',
];
