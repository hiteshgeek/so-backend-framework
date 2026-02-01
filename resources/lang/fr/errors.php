<?php

/**
 * French Error Messages
 *
 * HTTP error messages and application-specific errors.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | HTTP Error Messages
    |--------------------------------------------------------------------------
    */

    // 4xx Client Errors
    '400' => 'Mauvaise requête',
    '401' => 'Non autorisé',
    '402' => 'Paiement requis',
    '403' => 'Interdit',
    '404' => 'Non trouvé',
    '405' => 'Méthode non autorisée',
    '406' => 'Non acceptable',
    '408' => 'Délai d\'attente de la demande dépassé',
    '409' => 'Conflit',
    '410' => 'Disparu',
    '413' => 'Entité de requête trop grande',
    '415' => 'Type de média non pris en charge',
    '422' => 'Entité non traitable',
    '429' => 'Trop de requêtes',

    // 5xx Server Errors
    '500' => 'Erreur interne du serveur',
    '501' => 'Non implémenté',
    '502' => 'Mauvaise passerelle',
    '503' => 'Service indisponible',
    '504' => 'Délai d\'attente de la passerelle dépassé',
    '505' => 'Version HTTP non prise en charge',

    /*
    |--------------------------------------------------------------------------
    | Detailed Error Messages
    |--------------------------------------------------------------------------
    */

    'bad_request' => 'La requête n\'a pas pu être comprise par le serveur.',
    'unauthorized' => 'Vous devez vous authentifier pour accéder à cette ressource.',
    'forbidden' => 'Vous n\'avez pas la permission d\'accéder à cette ressource.',
    'not_found' => 'La ressource demandée est introuvable.',
    'method_not_allowed' => 'La méthode spécifiée dans la requête n\'est pas autorisée.',
    'not_acceptable' => 'La ressource n\'est capable de générer que du contenu non acceptable.',
    'request_timeout' => 'Le serveur a expiré en attendant la requête.',
    'conflict' => 'La requête n\'a pas pu être complétée en raison d\'un conflit.',
    'gone' => 'La ressource demandée n\'est plus disponible.',
    'payload_too_large' => 'La requête est plus grande que le serveur ne peut traiter.',
    'unsupported_media_type' => 'Le format des données de la requête n\'est pas pris en charge.',
    'unprocessable_entity' => 'La requête est bien formée mais n\'a pas pu être traitée.',
    'too_many_requests' => 'Vous avez envoyé trop de requêtes dans un laps de temps donné.',
    'internal_server_error' => 'Le serveur a rencontré une erreur inattendue.',
    'not_implemented' => 'Le serveur ne prend pas en charge la fonctionnalité requise.',
    'bad_gateway' => 'Le serveur a reçu une réponse invalide d\'un serveur en amont.',
    'service_unavailable' => 'Le serveur est temporairement incapable de traiter la requête.',
    'gateway_timeout' => 'Le serveur n\'a pas reçu de réponse en temps voulu d\'un serveur en amont.',

    /*
    |--------------------------------------------------------------------------
    | Application Errors
    |--------------------------------------------------------------------------
    */

    'database_error' => 'Une erreur de base de données s\'est produite.',
    'connection_failed' => 'Échec de la connexion au serveur.',
    'timeout' => 'L\'opération a expiré.',
    'file_not_found' => 'Le fichier est introuvable.',
    'permission_denied' => 'Permission refusée.',
    'operation_failed' => 'L\'opération a échoué.',
    'invalid_operation' => 'Opération invalide.',
    'resource_locked' => 'La ressource est verrouillée.',
    'quota_exceeded' => 'Quota dépassé.',

    /*
    |--------------------------------------------------------------------------
    | Validation Errors
    |--------------------------------------------------------------------------
    */

    'validation_error' => 'Erreur de validation.',
    'invalid_input' => 'Entrée invalide.',
    'missing_field' => 'Champ obligatoire manquant.',
    'invalid_format' => 'Format invalide.',
    'invalid_value' => 'Valeur invalide.',

    /*
    |--------------------------------------------------------------------------
    | Authentication Errors
    |--------------------------------------------------------------------------
    */

    'authentication_failed' => 'L\'authentification a échoué.',
    'invalid_token' => 'Jeton invalide.',
    'token_expired' => 'Le jeton a expiré.',
    'session_expired' => 'La session a expiré.',
    'account_locked' => 'Le compte est verrouillé.',
    'account_disabled' => 'Le compte est désactivé.',

    /*
    |--------------------------------------------------------------------------
    | Generic Error
    |--------------------------------------------------------------------------
    */

    'error' => 'Une erreur s\'est produite.',
    'unknown_error' => 'Une erreur inconnue s\'est produite.',
    'try_again' => 'Veuillez réessayer plus tard.',
];
