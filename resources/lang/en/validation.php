<?php

/**
 * English Validation Messages
 *
 * Validation error messages for all validation rules.
 * These messages support parameter replacement using :attribute, :min, :max, etc.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator. Some of these rules have multiple versions such as the
    | size rules. Feel free to tweak each of these messages here.
    |
    */

    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'email' => 'The :attribute must be a valid email address.',
    'url' => 'The :attribute must be a valid URL.',
    'ip' => 'The :attribute must be a valid IP address.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'numeric' => 'The :attribute must be a number.',
    'integer' => 'The :attribute must be an integer.',
    'string' => 'The :attribute must be a string.',
    'array' => 'The :attribute must be an array.',
    'boolean' => 'The :attribute must be true or false.',
    'min' => 'The :attribute must be at least :min.',
    'max' => 'The :attribute may not be greater than :max.',
    'between' => 'The :attribute must be between :min and :max.',
    'in' => 'The selected :attribute is invalid.',
    'not_in' => 'The selected :attribute is invalid.',
    'same' => 'The :attribute and :other must match.',
    'different' => 'The :attribute and :other must be different.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'before' => 'The :attribute must be a date before :date.',
    'after' => 'The :attribute must be a date after :date.',
    'unique' => 'The :attribute has already been taken.',
    'exists' => 'The selected :attribute is invalid.',
    'regex' => 'The :attribute format is invalid.',
    'json' => 'The :attribute must be a valid JSON string.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'email' => [
            'required' => 'We need to know your email address.',
            'email' => 'Please provide a valid email address.',
        ],
        'password' => [
            'required' => 'Password is required.',
            'min' => 'Password must be at least :min characters.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Attribute Names
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'email' => 'email address',
        'password' => 'password',
        'password_confirmation' => 'password confirmation',
        'name' => 'name',
        'username' => 'username',
        'first_name' => 'first name',
        'last_name' => 'last name',
        'phone' => 'phone number',
        'address' => 'address',
        'city' => 'city',
        'state' => 'state',
        'zip' => 'ZIP code',
        'country' => 'country',
        'age' => 'age',
        'date_of_birth' => 'date of birth',
        'title' => 'title',
        'description' => 'description',
        'content' => 'content',
        'category' => 'category',
        'status' => 'status',
        'price' => 'price',
        'quantity' => 'quantity',
        'sku' => 'SKU',
        'stock' => 'stock',
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Failed Message
    |--------------------------------------------------------------------------
    */

    'failed' => 'Validation failed.',
];
