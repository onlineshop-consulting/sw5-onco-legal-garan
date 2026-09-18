# Shopware 5 EU-Gewährleistungs-Hinweis Plugin

Zeigt den harmonisierten EU-Hinweis auf die gesetzliche Gewährleistung gemäß
Richtlinie (EU) 2024/825 und Durchführungsverordnung (EU) 2025/1960 an.

## Features

- Link "Ihre gesetzlichen Gewährleistungsrechte"; erster Klick öffnet den
  vollständigen offiziellen Hinweis im Modal
- Position konfigurierbar: Bestellabschluss-Seite (Standard), Produktdetailseite,
  Warenkorb (Seite, Off-Canvas und "Artikel hinzugefügt"-Popup) und/oder
  eigener CSS-Selektor (auf jeder Seite)
- Zusätzlich zwei Direkt-Varianten ohne Modal (Hinweis wird sofort angezeigt,
  Your-Europe-Link darunter): Bestellabschluss-Seite und eigener CSS-Selektor
- Klickbarer Link zum Your-Europe-Portal (gleiches Ziel wie der QR-Code des Hinweises)
- Button in der Plugin-Konfiguration hängt das offizielle Hinweis-PDF an die
  sORDER-Bestellbestätigung an (pro Shop in der jeweiligen Shopsprache, erneut
  klickbar nach dem Anlegen neuer Shops)
- Alle 24 EU-Amtssprachen enthalten (offizielle SVGs, PDFs, Snippets, Links);
  unbekannte Sprachen nutzen Englisch
- Die offiziellen Dateien der EU-Kommission sind unverändert eingebunden:
  https://commission.europa.eu/publications/high-resolution-vector-files-eu-notice-and-label-product-guarantees_en

## Installation

1. ZIP herunterladen: https://github.com/onlineshop-consulting/sw5-onco-legal-garan/releases
2. Im Shopware-Backend unter **Einstellungen > Plugin-Manager** installieren und aktivieren
3. Cache leeren und Theme neu kompilieren
4. In der Plugin-Konfiguration den Button **"Hinweis-PDF an Bestellbestätigung
   anhängen"** klicken

## Konfiguration
Die Konfiguration wird in diesem Video erklärt:
https://onlineshop.consulting/videos/plugins/sw5/onco-legal-garan.mp4

Anzeige-Positionen und PDF-Anhang sind pro Shop konfigurierbar. Bei der
Deinstallation werden angelegte Mail-Anhänge und Medien wieder entfernt
(außer bei "Daten behalten").

## Für Entwickler: Anzeige per Event unterdrücken

Vor jeder Frontend-Seite feuert das Plugin das Filter-Event
`OncoLegalGaran_Filter_ShowNotice`. Gibt ein Listener `false` zurück, wird der Hinweis auf
dieser Seite an keiner Position angezeigt. 

## Kompatibilität

Shopware 5.4.0+
PHP 5.6+

## Nicht enthalten

Das EU-GARAN-Label für Haltbarkeitsgarantien der Hersteller (Abschnitt 3 der EU-Leitlinien).
