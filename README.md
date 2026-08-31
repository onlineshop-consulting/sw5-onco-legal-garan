# Shopware 5 EU-Gewährleistungs-Hinweis Plugin

Zeigt den harmonisierten EU-Hinweis auf die gesetzliche Gewährleistung gemäß
Richtlinie (EU) 2024/825 und Durchführungsverordnung (EU) 2025/1960 an.

## Features

- Link "Ihre gesetzlichen Gewährleistungsrechte" auf der Bestellabschluss-Seite;
  erster Klick öffnet den vollständigen offiziellen Hinweis im Modal
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

## Konfiguration
Die Konfiguration wird in diesem Video erklärt:
https://onlineshop.consulting/videos/plugins/sw5/onco-withdrawal.mp4

## Kompatibilität

Shopware 5.4.0+
PHP 5.6+

## Nicht enthalten

Optionale Platzierungen (Katalogseiten, Header) sowie das EU-GARAN-Label für
Haltbarkeitsgarantien der Hersteller (Abschnitt 3 der EU-Leitlinien).
