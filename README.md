# Projekt: SoftwareSupply

Dieses Projekt ist eine Webanwendung, die es Benutzern ermöglicht, Software zu kaufen. Die Anwendung bietet die Möglichkeit, Software zu bestellen und eine Liste der getätigten Bestellungen anzuzeigen. Zusätzlich gibt es die Funktion, Gutscheine einzulösen und Rechnungen anzuzeigen in PDF Form/drucken.

## Funktionen

- Benutzerregistrierung und -anmeldung: Benutzer können sich registrieren und anmelden, um die Funktionen der Anwendung zu nutzen.
- Softwarekatalog: Eine Liste von verfügbaren Softwareprodukten mit Informationen zu jedem Produkt.
- Warenkorb: Benutzer können Softwareprodukte in ihren Warenkorb legen und die Anzahl der Artikel anpassen.
- Bestellung aufgeben: Benutzer können ihre Warenkorbartikel in eine Bestellung umwandeln und abschicken.
- Bestellungsverlauf: Benutzer können ihre früheren Bestellungen einsehen und deren Details anzeigen.
- Gutscheine: Benutzer können Gutscheincodes eingeben, um Rabatte auf ihre Bestellungen zu erhalten.

## Entwickler
Dieses Projekt wurde von Altin Klemendi und Julian Hoffmann entwickelt.
Die Haupttechnologien und Werkzeuge, die für die Entwicklung verwendet wurden, sind:

- PHP: Eine serverseitige Skriptsprache zur Entwicklung der Backend-Logik.
- Composer: Ein Paketmanager für PHP, der verwendet wurde, um Abhängigkeiten zu verwalten und externe Bibliotheken einzubinden.
- HTML/CSS: Zur Gestaltung und Darstellung der Benutzeroberfläche.
- JavaScript: Zur Implementierung von interaktiven Funktionen und AJAX-Anfragen.
- jQuery: Eine JavaScript-Bibliothek, die zur Vereinfachung der DOM-Manipulation und Event-Behandlung verwendet wurde.
- Bootstrap: Ein Open-Source-Framework für das Frontend-Design, das zur Erstellung responsiver und ansprechender Webseiten eingesetzt wurde.
- setasign/fpdf: Eine PHP-Bibliothek zur Erzeugung von PDF-Dokumenten, die für das Erstellen von Rechnungen verwendet wurde.

## Projektstruktur
- `backend/api/api.php`: Nimmt alle HTTP-Anfragen entgegen und kümmert sich um die Verarbeitung der Anfragen und das Erstellen der entsprechenden Responses.
- `backend/files/`: Verzeichnis, in dem alle Rechnungen gespeichert werden.
- `backend/data/db/Database.php`: Enthält die Klasse mit grundlegenden Informationen zur Datenbank und Methoden zur Verbindungsherstellung und Ausführung von Datenbank-Statements. Hier befinden sich auch die DAOs für alle Objekte, die für Datenbankoperationen zuständig sind. Die DAOs sind im Verzeichnis `backend/data/` zu finden.
- `backend/model/`: Verzeichnis für das ORM (Object-Relational Mapping), das die Datenbanktabellen in Objekte abbildet.
- `backend/productpictures/`: Enthält Produktfotos.
- `backend/service/`: Beinhaltet den Service für das Erstellen von PDF-Dokumenten, wie Rechnungen.
- `frontend/js/`: Verzeichnis für alle JavaScript-Dateien, die AJAX-Operationen durchführen.
- `frontend/res/`: Enthält CSS-Dateien und Bilddateien für die Seiten.
- `frontend/sites/`: Hier befinden sich alle HTML-Seiten.

## Installation

1. Stellen Sie sicher, dass Sie PHP auf Ihrem Server installiert haben.
2. Klonen Sie das Projekt-Repository auf Ihren Server oder laden Sie die Dateien manuell hoch.
3. Navigieren Sie zum Projektverzeichnis und führen Sie `composer install` aus, um die erforderlichen Abhängigkeiten zu installieren.
4. Konfigurieren Sie Ihre Datenbankzugangsdaten in der Datei `Database.php`.
5. Importieren Sie die bereitgestellte SQL-Datei in Ihre Datenbank, um die erforderlichen Tabellen zu erstellen. (DB-Struktur unter backend/db.migration/delta)
6. Starten Sie Ihren Webserver und rufen Sie die Hauptseite des Projekts auf.

## Verwendung

1. Registrieren Sie sich als neuer Benutzer oder melden Sie sich mit Ihren Anmeldeinformationen an.
2. Durchsuchen Sie den Softwarekatalog und wählen Sie die gewünschten Produkte aus.
3. Legen Sie die ausgewählten Produkte in Ihren Warenkorb und passen Sie die Anzahl an.
4. Gehen Sie zur Bestellungsseite, überprüfen Sie Ihre Auswahl und geben Sie die Bestellung auf.
5. Überprüfen Sie Ihre Bestellungsliste, um den Verlauf und die Details Ihrer vergangenen Bestellungen anzuzeigen.
6. Um eine Rechnung als PDF angeziegt zu bekommen, drücken Sie auf Rechnung bei der Profil Seite.

Viel Spaß beim Benutzen des SoftwareShops SoftwareSupply!

## Lizenz

Dieses Projekt ist unter der MIT-Lizenz lizenziert. Weitere Informationen finden Sie in der Datei LICENSE.

## Authoren

- Altin Kelmendi
- Julian Hoffmann
