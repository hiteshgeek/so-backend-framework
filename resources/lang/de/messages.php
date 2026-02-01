<?php

/**
 * German General Messages
 *
 * General API response messages and system messages.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | General API Messages
    |--------------------------------------------------------------------------
    */

    // Success Messages
    'success' => 'Erfolg',
    'created' => 'Erfolgreich erstellt.',
    'updated' => 'Erfolgreich aktualisiert.',
    'deleted' => 'Erfolgreich gelöscht.',
    'saved' => 'Erfolgreich gespeichert.',
    'restored' => 'Erfolgreich wiederhergestellt.',

    // Error Messages
    'error' => 'Ein Fehler ist aufgetreten.',
    'not_found' => 'Ressource nicht gefunden.',
    'server_error' => 'Interner Serverfehler.',
    'bad_request' => 'Ungültige Anfrage.',
    'service_unavailable' => 'Dienst vorübergehend nicht verfügbar.',

    // Operation Messages
    'operation_success' => 'Operation erfolgreich abgeschlossen.',
    'operation_failed' => 'Operation fehlgeschlagen.',
    'processing' => 'Verarbeitung läuft...',
    'please_wait' => 'Bitte warten...',

    // Data Messages
    'no_data' => 'Keine Daten verfügbar.',
    'no_results' => 'Keine Ergebnisse gefunden.',
    'empty_list' => 'Liste ist leer.',
    'data_retrieved' => 'Daten erfolgreich abgerufen.',

    // Validation
    'invalid_input' => 'Ungültige Eingabe bereitgestellt.',
    'invalid_request' => 'Ungültige Anfrage.',
    'missing_required_fields' => 'Erforderliche Felder fehlen.',

    // Permissions
    'permission_denied' => 'Berechtigung verweigert.',
    'insufficient_permissions' => 'Unzureichende Berechtigungen.',
    'forbidden_view_user' => 'Verboten - Sie können nur Ihre eigenen Benutzerdaten anzeigen.',
    'forbidden_update_user' => 'Verboten - Sie können nur Ihre eigenen Benutzerdaten aktualisieren.',
    'forbidden_delete_user' => 'Verboten - Sie können diesen Benutzer nicht löschen.',

    // Resource Operations
    'resource_created' => ':resource erfolgreich erstellt.',
    'resource_updated' => ':resource erfolgreich aktualisiert.',
    'resource_deleted' => ':resource erfolgreich gelöscht.',
    'resource_not_found' => ':resource nicht gefunden.',
    'resource_exists' => ':resource existiert bereits.',

    // User Operations
    'user_created' => 'Benutzer erfolgreich erstellt!',
    'user_updated' => 'Benutzer erfolgreich aktualisiert!',
    'user_deleted' => 'Benutzer ":name" erfolgreich gelöscht.',

    // File Operations
    'file_uploaded' => 'Datei erfolgreich hochgeladen.',
    'file_upload_failed' => 'Datei-Upload fehlgeschlagen.',
    'file_deleted' => 'Datei erfolgreich gelöscht.',
    'file_not_found' => 'Datei nicht gefunden.',
    'file_too_large' => 'Datei ist zu groß.',
    'invalid_file_type' => 'Ungültiger Dateityp.',

    // Import/Export
    'import_success' => 'Import erfolgreich abgeschlossen.',
    'import_failed' => 'Import fehlgeschlagen.',
    'export_success' => 'Export erfolgreich abgeschlossen.',
    'export_failed' => 'Export fehlgeschlagen.',

    // Confirmation
    'confirm_delete' => 'Sind Sie sicher, dass Sie dies löschen möchten?',
    'confirm_action' => 'Sind Sie sicher, dass Sie diese Aktion ausführen möchten?',
    'cannot_be_undone' => 'Diese Aktion kann nicht rückgängig gemacht werden.',

    // Session
    'session_expired' => 'Ihre Sitzung ist abgelaufen. Bitte melden Sie sich erneut an.',
    'session_invalid' => 'Ungültige Sitzung.',
];
