<?php

namespace App\Controllers\Api\Demo;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;
use Core\Validation\Validator;

/**
 * Validation Demo Controller
 *
 * Handles validation demo requests for frontend demos.
 * Demonstrates backend validation with ErrorReporter integration.
 */
class ValidationDemoController
{
    /**
     * Validate contact form
     *
     * Demonstrates backend validation with ErrorReporter integration.
     * Returns validation errors in JSON format compatible with ErrorReporter.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function validateContact(Request $request): JsonResponse
    {
        // Validation rules - using 'bail' to stop at first failure per field
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|min:3|max:100',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|regex:/^[0-9]{10}$/',
            'message' => 'bail|required|min:10|max:500',
        ], [
            // Custom messages
            'name.required' => 'Please enter your full name',
            'name.min' => 'Name must be at least 3 characters',
            'name.max' => 'Name cannot exceed 100 characters',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'phone.required' => 'Phone number is required',
            'phone.regex' => 'Phone must be 10 digits (e.g., 1234567890)',
            'message.required' => 'Please enter a message',
            'message.min' => 'Message must be at least 10 characters',
            'message.max' => 'Message cannot exceed 500 characters',
        ]);

        // Check validation
        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, $validator->errors());
        }

        // Simulate additional business logic validation
        $email = $request->input('email');
        $blockedDomains = ['spam.com', 'blocked.com', 'test.com'];
        $emailDomain = substr(strrchr($email, "@"), 1);

        if (in_array($emailDomain, $blockedDomains)) {
            return JsonResponse::error('Validation failed', 422, [
                'email' => ['This email domain is not allowed']
            ]);
        }

        // Success - return formatted response
        return JsonResponse::success([
            'message' => 'Form validated successfully! Data received.',
            'data' => $request->only(['name', 'email', 'phone', 'message'])
        ]);
    }
}
