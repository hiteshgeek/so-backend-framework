<?php

namespace App\Requests\Auth;

use Core\Http\Request;

/**
 * LoginRequest
 *
 * Request validation class
 */
class LoginRequest
{
    /**
     * Get the validation rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            // Example validation rules:
            // 'name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users',
            // 'password' => 'required|min:8|confirmed',
            // 'age' => 'integer|min:18|max:100',
            // 'status' => 'in:active,inactive,pending',
        ];
    }

    /**
     * Static helper to validate request data
     *
     * @param Request $request
     * @return array Validated data
     * @throws \Exception If validation fails
     */
    public static function validate(Request $request): array
    {
        $instance = new static();
        $rules = $instance->rules();
        $data = $request->all();

        // TODO: Implement actual validation logic
        // This is a placeholder - integrate with your validation system

        return $data;
    }

    /**
     * Get custom error messages for validation rules
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            // Example custom messages:
            // 'name.required' => 'The name field is required.',
            // 'email.email' => 'Please provide a valid email address.',
        ];
    }

    /**
     * Get custom attribute names for validation
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            // Example custom attribute names:
            // 'email' => 'email address',
            // 'password' => 'password',
        ];
    }
}