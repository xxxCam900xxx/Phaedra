# Phaedra Site Editor Konzept
In diesem Projekt wird ein einfach anwendbarer aber auch komplexer Site Editor gebaut werden, welche neue Seiten erstellen & bearbeiten kann sowie die Inhalte davon jederzeit Live überarbeiten kann. Es soll dynamisch und Modular sein.

## Inhaltsverzeichnis
- [Phaedra Site Editor Konzept](#phaedra-site-editor-konzept)
  - [Inhaltsverzeichnis](#inhaltsverzeichnis)
  - [Ziele](#ziele)
  - [Technologie](#technologie)
  - [Datenbank Struktur](#datenbank-struktur)
  - [Abläufe](#abläufe)

## Ziele
Hier sind alle Anforderungen und Ziele aufgeführt, die das Projekt erfüllen muss.

- [ ] **Allgemein**
  - [x] Bei Applikationsstart sollte eine Index Seite automatisch vordefiniert eingestellt sein, um an ihr rumbasteln zu können
  - [x] Navigation sollte sich automatisch anpassen, wenn eine neue Seite hinzugefügt wird und Online ist.
  - [ ] Wenn man in der Applikation auf eine Seite führt welche nicht gibt oder man keine Authorizierung hat, sollte man weitergeleitet werden.

- [ ] **Editor**
  - [x] Neue Seiten erstellen können
  - [ ] Bestehende Seiten kopieren können
  - [x] Bestehende Seiten löschen können
  - [x] Im Editor Layout Blöcke hinzufügen könne
  - [x] Im Editor Widgets hinzufügen können
  - [x] Inhalte bearbeiten können
  - [x] Automatisch abspeichern
  - [x] Live Übertragung
  - [ ] Offline Seiten / Unsichtbare Seiten
  - [x] Pro Seite Header Titel anpassen können, sowie Meta Tags
  - [ ] 404 Seite definieren können
  - [ ] 401 Seite definieren können

- [x] **Layout**
  - [x] Volle Breite
  - [x] 3 Spalten
  - [x] 2 Spalten

- [x] **Widgets**
  - [x] HTML Code Block
  - [x] Text Block
  - [x] Bild Block

---

## Technologie
- **Frontend**:
  - HTML / PHP
  - TailwindCSS
- **Backend**
  - PHP
- **Datenbank** 
  - PostgreSQL

## Datenbank Struktur
[Database](./media/DatabaseStructure.drawio)

## Abläufe

1. Launcher
Nachdem alle Fragen beantwortet wurden sind. Führt der Launcher folgendes durch:
- Die Daten werden auf der Datenbank abgespeichert

2. Editor
Im Editor sollte man mit einem Iframe durch die Webseite navigieren können. Links davon sind Layoutblöcke welche man in den Container ziehen kann, die werden dann direkt mit einer Abfrage zur Datenbank abgespeichert.

Wenn man eine neue Seite erstellt wird diese Abgespeichert mit PageCOntent und Page

3. Loading Site
Jede Seite wird von Datenabgefragt und durch die ID werden die richtigen Komponenten mit den richitgen Inhalten erstellt.

4. Navigation
Die Navigation sollte Dynamisch hergestellt werden. Sie nimmt alle bestehenden Seiten auf der Datenbank und verlinkt diese in die richtigen Ordner?