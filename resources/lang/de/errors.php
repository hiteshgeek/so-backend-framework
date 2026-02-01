<?php

/**
 * German Error Messages
 */

return [
    // HTTP Errors
    '400' => 'Ungültige Anfrage', '401' => 'Nicht autorisiert', '402' => 'Zahlung erforderlich',
    '403' => 'Verboten', '404' => 'Nicht gefunden', '405' => 'Methode nicht erlaubt',
    '406' => 'Nicht akzeptabel', '408' => 'Zeitüberschreitung der Anfrage',
    '409' => 'Konflikt', '410' => 'Nicht mehr vorhanden', '413' => 'Anfrage zu groß',
    '415' => 'Nicht unterstützter Medientyp', '422' => 'Nicht verarbeitbare Entität',
    '429' => 'Zu viele Anfragen', '500' => 'Interner Serverfehler',
    '501' => 'Nicht implementiert', '502' => 'Fehlerhaftes Gateway',
    '503' => 'Dienst nicht verfügbar', '504' => 'Gateway-Zeitüberschreitung',
    '505' => 'HTTP-Version nicht unterstützt',

    // Detailed Messages
    'bad_request' => 'Die Anfrage konnte vom Server nicht verstanden werden.',
    'unauthorized' => 'Sie müssen sich authentifizieren, um auf diese Ressource zuzugreifen.',
    'forbidden' => 'Sie haben keine Berechtigung, auf diese Ressource zuzugreifen.',
    'not_found' => 'Die angeforderte Ressource wurde nicht gefunden.',
    'method_not_allowed' => 'Die in der Anfrage angegebene Methode ist nicht erlaubt.',
    'not_acceptable' => 'Die Ressource kann nur nicht akzeptierbaren Inhalt generieren.',
    'request_timeout' => 'Der Server hat bei Warten auf die Anfrage eine Zeitüberschreitung festgestellt.',
    'conflict' => 'Die Anfrage konnte aufgrund eines Konflikts nicht abgeschlossen werden.',
    'gone' => 'Die angeforderte Ressource ist nicht mehr verfügbar.',
    'payload_too_large' => 'Die Anfrage ist größer als der Server verarbeiten kann.',
    'unsupported_media_type' => 'Das Datenformat der Anfrage wird nicht unterstützt.',
    'unprocessable_entity' => 'Die Anfrage ist wohlgeformt, konnte aber nicht verarbeitet werden.',
    'too_many_requests' => 'Sie haben zu viele Anfragen in einem bestimmten Zeitraum gesendet.',
    'internal_server_error' => 'Der Server ist auf einen unerwarteten Fehler gestoßen.',
    'not_implemented' => 'Der Server unterstützt die erforderliche Funktionalität nicht.',
    'bad_gateway' => 'Der Server hat eine ungültige Antwort von einem Upstream-Server erhalten.',
    'service_unavailable' => 'Der Server ist vorübergehend nicht in der Lage, die Anfrage zu bearbeiten.',
    'gateway_timeout' => 'Der Server hat nicht rechtzeitig eine Antwort von einem Upstream-Server erhalten.',

    // Application Errors
    'database_error' => 'Ein Datenbankfehler ist aufgetreten.',
    'connection_failed' => 'Verbindung zum Server fehlgeschlagen.',
    'timeout' => 'Die Operation hat eine Zeitüberschreitung festgestellt.',
    'file_not_found' => 'Die Datei wurde nicht gefunden.',
    'permission_denied' => 'Berechtigung verweigert.',
    'operation_failed' => 'Die Operation ist fehlgeschlagen.',
    'invalid_operation' => 'Ungültige Operation.',
    'resource_locked' => 'Die Ressource ist gesperrt.',
    'quota_exceeded' => 'Kontingent überschritten.',

    // Validation Errors
    'validation_error' => 'Validierungsfehler.',
    'invalid_input' => 'Ungültige Eingabe.',
    'missing_field' => 'Erforderliches Feld fehlt.',
    'invalid_format' => 'Ungültiges Format.',
    'invalid_value' => 'Ungültiger Wert.',

    // Authentication Errors
    'authentication_failed' => 'Die Authentifizierung ist fehlgeschlagen.',
    'invalid_token' => 'Ungültiger Token.',
    'token_expired' => 'Der Token ist abgelaufen.',
    'session_expired' => 'Die Sitzung ist abgelaufen.',
    'account_locked' => 'Das Konto ist gesperrt.',
    'account_disabled' => 'Das Konto ist deaktiviert.',

    // Generic
    'error' => 'Ein Fehler ist aufgetreten.',
    'unknown_error' => 'Ein unbekannter Fehler ist aufgetreten.',
    'try_again' => 'Bitte versuchen Sie es später erneut.',
];
