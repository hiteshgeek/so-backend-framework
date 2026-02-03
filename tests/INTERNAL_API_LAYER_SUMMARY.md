# Internal API Layer Summary

## Overview

The Internal API Layer provides a unified interface for making internal API calls within the framework, with automatic context detection and permission handling.

## Key Features

### Context Detection

Automatically detects the calling context:
- Web requests
- Mobile app requests
- Cron jobs
- External integrations

### Permission Management

Context-based permissions ensure proper access control across different request sources.

### API Client

Built-in API client for making internal requests:

```php
use Core\Http\ApiClient;

$response = ApiClient::get('/api/users');
$users = $response->json();
```

## Architecture

The Internal API Layer sits between your application logic and external consumers, providing:

- Request normalization
- Response formatting
- Error handling
- Permission checking
- Rate limiting

## Implementation

```php
// Internal API call with context
$client = new ApiClient();
$client->withContext('mobile');
$response = $client->post('/api/orders', $data);
```

## Testing

Tests are located in `tests/Feature/InternalApi/` directory.

## Related Documentation

- [API Versioning](/docs/api-versioning)
- [Context-Based Permissions](/docs/context-permissions)
- [API Controllers](/docs/dev-api-controllers)
