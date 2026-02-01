<?php

/**
 * German Authentication Messages
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
    'login_success' => 'Anmeldung erfolgreich!',
    'login_failed' => 'Ungültige E-Mail oder Passwort.',
    'invalid_credentials' => 'Ungültige Anmeldedaten.',

    // Registration
    'registration_success' => 'Konto erfolgreich erstellt!',
    'registration_failed' => 'Die Registrierung ist fehlgeschlagen. Bitte versuchen Sie es erneut.',

    // Logout
    'logout_success' => 'Abmeldung erfolgreich.',

    // Password Reset
    'password_reset_sent' => 'Link zum Zurücksetzen des Passworts wurde an Ihre E-Mail gesendet.',
    'password_reset_success' => 'Passwort erfolgreich zurückgesetzt! Sie können sich jetzt mit Ihrem neuen Passwort anmelden.',
    'password_reset_failed' => 'Das Zurücksetzen des Passworts ist fehlgeschlagen. Bitte versuchen Sie es erneut.',
    'password_reset_token_invalid' => 'Ungültiger oder abgelaufener Token zum Zurücksetzen des Passworts.',
    'password_reset_token_expired' => 'Der Token zum Zurücksetzen des Passworts ist abgelaufen.',

    // Password Change
    'password_change_success' => 'Passwort erfolgreich geändert.',
    'password_change_failed' => 'Das aktuelle Passwort ist falsch.',

    // Authorization
    'unauthorized' => 'Sie sind nicht berechtigt, auf diese Ressource zuzugreifen.',
    'unauthenticated' => 'Sie müssen angemeldet sein, um auf diese Ressource zuzugreifen.',
    'access_denied' => 'Zugriff verweigert.',
    'forbidden' => 'Diese Aktion ist verboten.',

    // Token
    'token_invalid' => 'Ungültiger Authentifizierungstoken.',
    'token_expired' => 'Der Authentifizierungstoken ist abgelaufen.',
    'token_missing' => 'Der Authentifizierungstoken fehlt.',
    'token_revoked' => 'Der Authentifizierungstoken wurde widerrufen.',

    // Account Status
    'account_inactive' => 'Ihr Konto ist inaktiv. Bitte kontaktieren Sie den Support.',
    'account_suspended' => 'Ihr Konto wurde gesperrt.',
    'account_deleted' => 'Ihr Konto wurde gelöscht.',

    // Email Verification
    'email_verification_sent' => 'Bestätigungs-E-Mail gesendet.',
    'email_verified' => 'E-Mail erfolgreich bestätigt.',
    'email_not_verified' => 'Die E-Mail-Adresse ist nicht bestätigt.',
    'email_already_verified' => 'Die E-Mail-Adresse ist bereits bestätigt.',
];
