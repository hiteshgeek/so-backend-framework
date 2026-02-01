<?php

/**
 * French General Messages
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
    'success' => 'Succès',
    'created' => 'Créé avec succès.',
    'updated' => 'Mis à jour avec succès.',
    'deleted' => 'Supprimé avec succès.',
    'saved' => 'Enregistré avec succès.',
    'restored' => 'Restauré avec succès.',

    // Error Messages
    'error' => 'Une erreur est survenue.',
    'not_found' => 'Ressource introuvable.',
    'server_error' => 'Erreur interne du serveur.',
    'bad_request' => 'Mauvaise requête.',
    'service_unavailable' => 'Service temporairement indisponible.',

    // Operation Messages
    'operation_success' => 'Opération terminée avec succès.',
    'operation_failed' => 'L\'opération a échoué.',
    'processing' => 'Traitement en cours...',
    'please_wait' => 'Veuillez patienter...',

    // Data Messages
    'no_data' => 'Aucune donnée disponible.',
    'no_results' => 'Aucun résultat trouvé.',
    'empty_list' => 'La liste est vide.',
    'data_retrieved' => 'Données récupérées avec succès.',

    // Validation
    'invalid_input' => 'Entrée invalide fournie.',
    'invalid_request' => 'Requête invalide.',
    'missing_required_fields' => 'Champs obligatoires manquants.',

    // Permissions
    'permission_denied' => 'Permission refusée.',
    'insufficient_permissions' => 'Permissions insuffisantes.',
    'forbidden_view_user' => 'Interdit - vous ne pouvez voir que vos propres données utilisateur.',
    'forbidden_update_user' => 'Interdit - vous ne pouvez mettre à jour que vos propres données utilisateur.',
    'forbidden_delete_user' => 'Interdit - vous ne pouvez pas supprimer cet utilisateur.',

    // Resource Operations
    'resource_created' => ':resource créé avec succès.',
    'resource_updated' => ':resource mis à jour avec succès.',
    'resource_deleted' => ':resource supprimé avec succès.',
    'resource_not_found' => ':resource introuvable.',
    'resource_exists' => ':resource existe déjà.',

    // User Operations
    'user_created' => 'Utilisateur créé avec succès!',
    'user_updated' => 'Utilisateur mis à jour avec succès!',
    'user_deleted' => 'Utilisateur ":name" supprimé avec succès.',

    // File Operations
    'file_uploaded' => 'Fichier téléchargé avec succès.',
    'file_upload_failed' => 'Le téléchargement du fichier a échoué.',
    'file_deleted' => 'Fichier supprimé avec succès.',
    'file_not_found' => 'Fichier introuvable.',
    'file_too_large' => 'Le fichier est trop volumineux.',
    'invalid_file_type' => 'Type de fichier invalide.',

    // Import/Export
    'import_success' => 'Import terminé avec succès.',
    'import_failed' => 'L\'import a échoué.',
    'export_success' => 'Export terminé avec succès.',
    'export_failed' => 'L\'export a échoué.',

    // Confirmation
    'confirm_delete' => 'Êtes-vous sûr de vouloir supprimer ceci?',
    'confirm_action' => 'Êtes-vous sûr de vouloir effectuer cette action?',
    'cannot_be_undone' => 'Cette action ne peut pas être annulée.',

    // Session
    'session_expired' => 'Votre session a expiré. Veuillez vous reconnecter.',
    'session_invalid' => 'Session invalide.',
];
