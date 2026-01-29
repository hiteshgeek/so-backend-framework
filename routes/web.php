<?php

use Core\Routing\Router;
use Core\Http\Request;
use Core\Http\Response;

// Home route
Router::get('/', function (Request $request) {
    return Response::view('welcome');
});

// Example JSON API route
Router::get('/api/test', function (Request $request) {
    return \Core\Http\JsonResponse::success([
        'message' => 'Framework is working!',
        'version' => '1.0.0',
    ]);
});

// Example route with parameters
Router::get('/users/{id}', function (Request $request, $id) {
    return \Core\Http\JsonResponse::success([
        'user_id' => $id,
        'message' => 'User details',
    ]);
});
