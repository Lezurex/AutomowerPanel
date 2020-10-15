# AutomowerPanel

Mit dieser Website lässt sich der eigene Husvarna Automower auch auf dem PC steuern. Es werden die gängigen Befehle Starten, Stoppen und Parkieren unterstützt. Hierbei wird die offizielle API von Husqvarna verwendet. Jeder Benutzer kann sich mit seinem Husqvarna Konto anmelden und direkt loslegen.<br />
**DISCLAIMER**: Diese Seite war ein Probeprojekt eines Informatiklehrlings im ersten Lehrjahr. Die korrekte Funktion ist nicht garantiert! Jedoch darf dieses Projekt gerne weiterentwickelt werden.

## Funktionen
Dieses Control-Panel besitzt alle Funktionen, die die offizielle Husqvarna API zu bieten hat.
- Aktueller Status des Rasenmähers jederzeit einsehbar
- Starten des Mähers nach Zeitplan oder zeitlich begrenzter Override
- Parken des Mähers nach Zeitplan, zeitlich begrenzter Override oder bis auf Weiteres
- Stoppen des Mähers
- Falls mehrere Mäher im Konto vorhanden sind, kann man diese einzeln wählen und steuern
- Fehlermeldungen (Details ein-/ausklappbar)

## Installation

Um die Website selbst zu verwenden, muss noch eine zusätzliche Datei erstellt werden, worin die Konfiguration gespeichert ist. Dazu eine `config.php` Datei in `/php/` erstellen und den folgenden Code einfügen:
```PHP
<?php

function getAppKey() {
    return "APP_KEY"; // Enter your app key here
}

function getAppSecret() {
    return "APP_SECRET"; // Enter your app's secret here
}

function getActivityStrings() {
    return array(
        "UNKNOWN" => "Unbekannt",
        "NOT_APPLICABLE" => "Manueller Start notwendig",
        "MOWING" => "Mäht",
        "GOING_HOME" => "Geht nach Hause",
        "CHARGING" => "Lädt",
        "LEAVING" => "Verlässt Station",
        "PARKED_IN_CS" => "Geparkt in Station",
        "STOPPED_IN_GARDEN" => "Im Garten parkiert"
    );
}

function getStateStrings() {
    return array(
        "UNKNOWN" => "Unbekannt",
        "NOT_APPLICABLE" => "Manueller Start notwendig",
        "PAUSED" => "Pausiert",
        "IN_OPERATION" => "In Betrieb",
        "WAIT_UPDATING" => "Lädt Updates herunter",
        "WAIT_POWER_UP" => "Führt Starttests aus",
        "RESTRICTED" => "Eingeschränkt",
        "OFF" => "Ausgeschaltet",
        "STOPPED" => "Gestoppt - Eingriff notwendig",
        "ERROR" => "Fehler",
        "FATAL_ERROR" => "Fataler Fehler",
        "ERROR_AT_POWER_UP" => "Fehler beim Start"
    );
}

function getWeekdayStrings() {
    return array(
        "1" => "Montag",
        "2" => "Dienstag",
        "3" => "Mittwoch",
        "4" => "Donnerstag",
        "5" => "Freitag",
        "6" => "Samstag",
        "7" => "Sonntag"
    );
}
```
Eine neue Husqvarna Applikation kann unter https://developer.husqvarnagroup.cloud/apps erstellt werden. Hierbei muss die **Authentication API** und die **Automower Connect API** aktiviert sein.
In dieser Datei können auch noch gewisse Strings abgeändert werden, zum Beispiel für die verschiedenen Status.

## Verwendete Frameworks
### SB Admin
Für das Panel wurde das [Template von Start Bootstrap](https://startbootstrap.com/templates/sb-admin/) verwendet und modifiziert.

### Bootstrap & jQuery
Bei dieser Website wurde [Bootstrap](https://getbootstrap.com/) und [jQuery](https://jquery.com) verwendet.

# Lizenz
Dieses Projekt ist unter der GNU GPU v3 lizenziert und darf dementsprechend verwendet werden. Weitere Informationen dazu finden sich [hier](https://github.com/Lezurex/AutomowerPanel/blob/main/LICENSE).
