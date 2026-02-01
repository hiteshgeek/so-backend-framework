<?php

/**
 * French Validation Messages
 *
 * Validation error messages for form validation.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    */

    // Required fields
    'required' => 'Le champ :attribute est obligatoire.',
    'required_if' => 'Le champ :attribute est obligatoire quand :other est :value.',
    'required_with' => 'Le champ :attribute est obligatoire quand :values est présent.',
    'required_without' => 'Le champ :attribute est obligatoire quand :values n\'est pas présent.',

    // Format validation
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'url' => 'Le champ :attribute doit être une URL valide.',
    'alpha' => 'Le champ :attribute ne doit contenir que des lettres.',
    'alpha_num' => 'Le champ :attribute ne doit contenir que des lettres et des chiffres.',
    'numeric' => 'Le champ :attribute doit être un nombre.',
    'integer' => 'Le champ :attribute doit être un entier.',
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'array' => 'Le champ :attribute doit être un tableau.',
    'json' => 'Le champ :attribute doit être une chaîne JSON valide.',

    // Length validation
    'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
    'max' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
    'between' => 'Le champ :attribute doit être entre :min et :max.',
    'size' => 'Le champ :attribute doit faire :size.',

    // Comparison
    'same' => 'Le champ :attribute et :other doivent correspondre.',
    'different' => 'Le champ :attribute et :other doivent être différents.',
    'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',
    'in' => 'Le champ :attribute sélectionné est invalide.',
    'not_in' => 'Le champ :attribute sélectionné est invalide.',

    // Database
    'unique' => 'Le :attribute a déjà été pris.',
    'exists' => 'Le :attribute sélectionné est invalide.',

    // Date
    'date' => 'Le champ :attribute n\'est pas une date valide.',
    'date_format' => 'Le champ :attribute ne correspond pas au format :format.',
    'before' => 'Le champ :attribute doit être une date avant :date.',
    'after' => 'Le champ :attribute doit être une date après :date.',

    // File uploads
    'uploaded' => 'Le champ :attribute n\'a pas pu être téléchargé.',
    'file' => 'Le champ :attribute doit être un fichier.',
    'mimes' => 'Le champ :attribute doit être un fichier de type: :values.',
    'max_file_size' => 'Le champ :attribute ne doit pas dépasser :max kilo-octets.',

    // General
    'validation_failed' => 'La validation a échoué.',
    'invalid_input' => 'Entrée invalide fournie.',
    'failed' => 'La validation a échoué.',

    /*
    |--------------------------------------------------------------------------
    | Custom Attribute Names
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'name' => 'nom',
        'email' => 'adresse e-mail',
        'password' => 'mot de passe',
        'password_confirmation' => 'confirmation du mot de passe',
        'mobile' => 'mobile',
        'phone' => 'téléphone',
        'address' => 'adresse',
        'city' => 'ville',
        'country' => 'pays',
        'zip_code' => 'code postal',
        'date_of_birth' => 'date de naissance',
        'description' => 'description',
        'title' => 'titre',
        'content' => 'contenu',
        'status' => 'statut',
        'company_id' => 'entreprise',
    ],
];
