<?php

/**
 * English Error Messages
 *
 * Error messages for HTTP errors and application-specific errors.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | HTTP Error Messages
    |--------------------------------------------------------------------------
    */

    // 4xx Client Errors
    '400' => 'Bad Request',
    '401' => 'Unauthorized',
    '402' => 'Payment Required',
    '403' => 'Forbidden',
    '404' => 'Not Found',
    '405' => 'Method Not Allowed',
    '406' => 'Not Acceptable',
    '408' => 'Request Timeout',
    '409' => 'Conflict',
    '410' => 'Gone',
    '413' => 'Payload Too Large',
    '415' => 'Unsupported Media Type',
    '422' => 'Unprocessable Entity',
    '429' => 'Too Many Requests',

    // 5xx Server Errors
    '500' => 'Internal Server Error',
    '501' => 'Not Implemented',
    '502' => 'Bad Gateway',
    '503' => 'Service Unavailable',
    '504' => 'Gateway Timeout',

    /*
    |--------------------------------------------------------------------------
    | Application Error Messages
    |--------------------------------------------------------------------------
    */

    // Database Errors
    'database_error' => 'Database error occurred.',
    'database_connection_failed' => 'Could not connect to database.',
    'query_error' => 'Query execution failed.',
    'record_not_found' => 'Record not found.',
    'duplicate_entry' => 'Duplicate entry detected.',

    // File Errors
    'file_not_found' => 'File not found.',
    'file_read_error' => 'Could not read file.',
    'file_write_error' => 'Could not write to file.',
    'file_permission_denied' => 'File permission denied.',
    'directory_not_found' => 'Directory not found.',

    // Network Errors
    'network_error' => 'Network error occurred.',
    'connection_timeout' => 'Connection timeout.',
    'connection_refused' => 'Connection refused.',
    'host_not_found' => 'Host not found.',

    // Validation Errors
    'validation_error' => 'Validation error.',
    'invalid_data' => 'Invalid data provided.',
    'missing_parameter' => 'Required parameter missing: :parameter',
    'invalid_parameter' => 'Invalid parameter: :parameter',

    // Authentication Errors
    'authentication_failed' => 'Authentication failed.',
    'session_expired' => 'Session expired.',
    'invalid_token' => 'Invalid token.',
    'token_expired' => 'Token expired.',

    // Authorization Errors
    'permission_denied' => 'Permission denied.',
    'access_forbidden' => 'Access to this resource is forbidden.',
    'role_required' => 'Required role: :role',

    // Business Logic Errors
    'operation_not_allowed' => 'Operation not allowed.',
    'resource_locked' => 'Resource is locked.',
    'resource_in_use' => 'Resource is currently in use.',
    'quota_exceeded' => 'Quota exceeded.',
    'limit_reached' => 'Limit reached.',

    // Payment Errors
    'payment_failed' => 'Payment failed.',
    'insufficient_funds' => 'Insufficient funds.',
    'payment_declined' => 'Payment declined.',
    'payment_gateway_error' => 'Payment gateway error.',

    // Integration Errors
    'api_error' => 'API error occurred.',
    'third_party_error' => 'Third-party service error.',
    'integration_failed' => 'Integration failed.',

    // Generic Errors
    'unexpected_error' => 'An unexpected error occurred.',
    'something_went_wrong' => 'Something went wrong.',
    'please_try_again' => 'Please try again later.',
    'contact_support' => 'Please contact support if the problem persists.',
];
