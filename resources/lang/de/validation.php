<?php

/**
 * German Validation Messages
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
    'required' => 'Das Feld :attribute ist erforderlich.',
    'required_if' => 'Das Feld :attribute ist erforderlich, wenn :other :value ist.',
    'required_with' => 'Das Feld :attribute ist erforderlich, wenn :values vorhanden ist.',
    'required_without' => 'Das Feld :attribute ist erforderlich, wenn :values nicht vorhanden ist.',

    // Format validation
    'email' => 'Das Feld :attribute muss eine gültige E-Mail-Adresse sein.',
    'url' => 'Das Feld :attribute muss eine gültige URL sein.',
    'alpha' => 'Das Feld :attribute darf nur Buchstaben enthalten.',
    'alpha_num' => 'Das Feld :attribute darf nur Buchstaben und Zahlen enthalten.',
    'numeric' => 'Das Feld :attribute muss eine Zahl sein.',
    'integer' => 'Das Feld :attribute muss eine ganze Zahl sein.',
    'boolean' => 'Das Feld :attribute muss wahr oder falsch sein.',
    'array' => 'Das Feld :attribute muss ein Array sein.',
    'json' => 'Das Feld :attribute muss ein gültiger JSON-String sein.',

    // Length validation
    'min' => 'Das Feld :attribute muss mindestens :min Zeichen enthalten.',
    'max' => 'Das Feld :attribute darf nicht mehr als :max Zeichen enthalten.',
    'between' => 'Das Feld :attribute muss zwischen :min und :max liegen.',
    'size' => 'Das Feld :attribute muss :size sein.',

    // Comparison
    'same' => 'Das Feld :attribute und :other müssen übereinstimmen.',
    'different' => 'Das Feld :attribute und :other müssen unterschiedlich sein.',
    'confirmed' => 'Die Bestätigung für :attribute stimmt nicht überein.',
    'in' => 'Das ausgewählte :attribute ist ungültig.',
    'not_in' => 'Das ausgewählte :attribute ist ungültig.',

    // Database
    'unique' => 'Das :attribute wurde bereits verwendet.',
    'exists' => 'Das ausgewählte :attribute ist ungültig.',

    // Date
    'date' => 'Das Feld :attribute ist kein gültiges Datum.',
    'date_format' => 'Das Feld :attribute entspricht nicht dem Format :format.',
    'before' => 'Das Feld :attribute muss ein Datum vor :date sein.',
    'after' => 'Das Feld :attribute muss ein Datum nach :date sein.',

    // File uploads
    'uploaded' => 'Das Feld :attribute konnte nicht hochgeladen werden.',
    'file' => 'Das Feld :attribute muss eine Datei sein.',
    'mimes' => 'Das Feld :attribute muss eine Datei vom Typ :values sein.',
    'max_file_size' => 'Das Feld :attribute darf nicht größer als :max Kilobyte sein.',

    // General
    'validation_failed' => 'Die Validierung ist fehlgeschlagen.',
    'invalid_input' => 'Ungültige Eingabe bereitgestellt.',
    'failed' => 'Die Validierung ist fehlgeschlagen.',

    /*
    |--------------------------------------------------------------------------
    | Custom Attribute Names
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'name' => 'Name',
        'email' => 'E-Mail-Adresse',
        'password' => 'Passwort',
        'password_confirmation' => 'Passwortbestätigung',
        'mobile' => 'Mobiltelefon',
        'phone' => 'Telefon',
        'address' => 'Adresse',
        'city' => 'Stadt',
        'country' => 'Land',
        'zip_code' => 'Postleitzahl',
        'date_of_birth' => 'Geburtsdatum',
        'description' => 'Beschreibung',
        'title' => 'Titel',
        'content' => 'Inhalt',
        'status' => 'Status',
        'company_id' => 'Unternehmen',
    ],
];
