<?php

/**
 * German Notification Templates
 */

return [
    'welcome' => [
        'title' => 'Willkommen im System!',
        'message' => 'Hallo :name, willkommen in unserem ERP-System! Wir freuen uns, Sie an Bord zu haben.',
        'action' => 'Zum Dashboard',
    ],
    'order' => [
        'created' => ['title' => 'Bestellung erstellt', 'message' => 'Ihre Bestellung #:order_id wurde erfolgreich erstellt.', 'action' => 'Bestellung anzeigen'],
        'updated' => ['title' => 'Bestellung aktualisiert', 'message' => 'Ihre Bestellung #:order_id wurde aktualisiert.', 'action' => 'Bestellung anzeigen'],
        'shipped' => ['title' => 'Bestellung versendet', 'message' => 'Ihre Bestellung #:order_id wurde versendet. Sendungsnummer: :tracking_number', 'action' => 'Bestellung verfolgen'],
        'delivered' => ['title' => 'Bestellung geliefert', 'message' => 'Ihre Bestellung #:order_id wurde erfolgreich geliefert.', 'action' => 'Bestellung anzeigen'],
        'cancelled' => ['title' => 'Bestellung storniert', 'message' => 'Ihre Bestellung #:order_id wurde storniert.', 'action' => 'Bestellung anzeigen'],
        'approval_required' => ['title' => 'Bestellgenehmigung erforderlich', 'message' => 'Bestellung #:order_id erfordert Ihre Genehmigung.', 'action' => 'Bestellung prüfen'],
    ],
    'user' => [
        'account_created' => ['title' => 'Konto erstellt', 'message' => 'Ihr Konto wurde erfolgreich erstellt. Willkommen!', 'action' => 'Anmelden'],
        'password_changed' => ['title' => 'Passwort geändert', 'message' => 'Ihr Passwort wurde erfolgreich geändert.', 'action' => null],
        'profile_updated' => ['title' => 'Profil aktualisiert', 'message' => 'Ihre Profilinformationen wurden erfolgreich aktualisiert.', 'action' => 'Profil anzeigen'],
        'role_changed' => ['title' => 'Rolle geändert', 'message' => 'Ihre Rolle wurde auf :role geändert.', 'action' => null],
    ],
    'payment' => [
        'received' => ['title' => 'Zahlung erhalten', 'message' => 'Ihre Zahlung von :amount wurde erfolgreich erhalten.', 'action' => 'Quittung anzeigen'],
        'failed' => ['title' => 'Zahlung fehlgeschlagen', 'message' => 'Ihre Zahlung von :amount ist fehlgeschlagen. Bitte versuchen Sie es erneut.', 'action' => 'Zahlung wiederholen'],
        'refunded' => ['title' => 'Zahlung erstattet', 'message' => 'Ihre Zahlung von :amount wurde erstattet.', 'action' => 'Details anzeigen'],
    ],
    'system' => [
        'maintenance' => ['title' => 'Geplante Wartung', 'message' => 'Das System wird von :start_time bis :end_time gewartet.', 'action' => null],
        'update' => ['title' => 'Systemaktualisierung', 'message' => 'Das System wurde auf Version :version aktualisiert.', 'action' => 'Änderungen anzeigen'],
        'backup_complete' => ['title' => 'Sicherung abgeschlossen', 'message' => 'Die Systemsicherung wurde erfolgreich abgeschlossen.', 'action' => null],
    ],
    'task' => [
        'assigned' => ['title' => 'Aufgabe zugewiesen', 'message' => 'Eine neue Aufgabe wurde Ihnen zugewiesen: :task_name', 'action' => 'Aufgabe anzeigen'],
        'completed' => ['title' => 'Aufgabe abgeschlossen', 'message' => 'Die Aufgabe :task_name wurde abgeschlossen.', 'action' => 'Aufgabe anzeigen'],
        'due_soon' => ['title' => 'Aufgabe bald fällig', 'message' => 'Die Aufgabe :task_name ist in :hours Stunden fällig.', 'action' => 'Aufgabe anzeigen'],
    ],
    'general' => [
        'info' => ['title' => 'Information', 'message' => ':message', 'action' => 'Mehr erfahren'],
        'warning' => ['title' => 'Warnung', 'message' => ':message', 'action' => 'Details anzeigen'],
        'error' => ['title' => 'Fehler', 'message' => ':message', 'action' => 'Problem melden'],
        'success' => ['title' => 'Erfolg', 'message' => ':message', 'action' => null],
    ],
];
