![Phaedra Banner](/concept/media/Phaedra_Banner.png)

# Willkommen bei der Phaedra Dokumentation
Schön dich hier zu sehen! Diese Dokumentation ist wie ein Handbuch für die Applikation. Ich habe hier alles wichtige aufgeschrieben was Sie wissen müssen.

***Wie kann man ihnen behilflich sein?***

---

## Inhaltsverzeichnis
- [Willkommen bei der Phaedra Dokumentation](#willkommen-bei-der-phaedra-dokumentation)
  - [Inhaltsverzeichnis](#inhaltsverzeichnis)
  - [Wie setzte ich dieses Programm auf?](#wie-setzte-ich-dieses-programm-auf)
    - [Datenbank vorbereiten](#datenbank-vorbereiten)
    - [Editor aufsetzen](#editor-aufsetzen)
  - [Admin Backend](#admin-backend)
    - [Dashboard](#dashboard)
    - [Site-Editor](#site-editor)
    - [Dateimanager](#dateimanager)
    - [Einstellungen](#einstellungen)
    - [Profil](#profil)
    - [Timeline](#timeline)
    - [Socials](#socials)
    - [FAQ](#faq)
  - [Wie bearbeite ich meine Seite?](#wie-bearbeite-ich-meine-seite)
    - [Layouts](#layouts)
    - [Widgets](#widgets)
    - [Design](#design)
  - [Wie erstelle ich eine neue Seite?](#wie-erstelle-ich-eine-neue-seite)
  - [Wie bearbeite ich meine Web-Konfigurationen?](#wie-bearbeite-ich-meine-web-konfigurationen)
  - [Wie ändere ich mein Login Passwort?](#wie-ändere-ich-mein-login-passwort)
  - [Wie füge ich neue Bilder \& Videos hinzu?](#wie-füge-ich-neue-bilder--videos-hinzu)
  - [Wie erstelle ich Social Links?](#wie-erstelle-ich-social-links)
  - [Wie erstelle ich meine Timeline?](#wie-erstelle-ich-meine-timeline)
  - [Wie erstelle \& beantworte ich meine FAQs?](#wie-erstelle--beantworte-ich-meine-faqs)

## Wie setzte ich dieses Programm auf?
Der Phaedra Site Editor ist ein sehr einfaches Programm, um es auf seiner eigenen Domain auf zu setzen. Man benötigt Hauptsächlich einen **Apache Server mit FTP Zugriff** und eine **Datenbank verbindung**.

### Datenbank vorbereiten
1. Gehen Sie auf ihre Anbieter Plattform und erstellen sich eine leere Datenbank.
2. Notieren Sie sich die Login daten für auf die Datenbank

### Editor aufsetzen
1. Als aller erstes ziehen Sie sich eine Kopie des Projekts runter
2. Gehen Sie im `app` Ordner auf `api/config/enviroment.php` und ändern Sie alle ``getEnv`` Felder
```php
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));
define('ENCRYPTION_IV', getenv('ENCRYPTION_IV'));
define('ENCRYPTION_KEY', getenv('ENCRYPTION_KEY'));
```
3. Danach kopieren Sie den `app` Ordner einfach auf den FTP Server

Nachdem Sie den Editor aufgesetzt haben sollen Sie auf ihre Webseite gehen, danach werden Sie direkt in den Launcher geworfen. Füllen Sie dann alles aus und Sie sind bereit den Editor zu benutzen und ihre eigene Webseite zu bauen!

## Admin Backend
Sie können im Admin Backend bearbeiten. In diesem Abschnitt erkläre ich ihnnen kurz und knackig die einzelen Sektoren im Admin Backend.

### Dashboard
Das Dashboard hat nicht all zu wichtige Infomationen. Grunsätzlich sehen Sie hier wie viele Fehler es Pro Jahr gegeben hat, wie viele Besucher sie dieses Jahr hatten und wie viel Speicherplatz sie im Upload Folder besetzen.

![Admin Dashboard View](/concept/media/AdminDashboardView.png)

### Site-Editor
Der Site-Editor ist das Herzstück des Programms. Hier spielt die Musik hauptsächlich! Sie können auf dem Site-Editor in Echtzeit änderungen machen und diese direkt anschauen. Sie können hier Layout, Widgets und Seite hinzufügen und bearbeiten. Sie können auch das Design ändern.

![SiteEditor View](/concept/media/SiteEditorView.png)

### Dateimanager
Im Dateimanager sehen Sie alle Bilder & Videos welche Sie hochgeladen haben. Hier können Sie neue Medien hinzufügen und löschen.

![Dateimanager View](/concept/media/FileManagerView.png)

### Einstellungen
In den Einstellungen können Sie den Domainname hinterlegen, den Betreiber der Webseite, ihre E-Mail Adresse für das Konaktformualr und ein Webseiten Logo.

![Settings View](/concept/media/SettingsView.png)

### Profil
Auf der Profil Seite können Sie hauptsächlich ihr bestehendes Passwort ändern! **Am besten geben Sie schon im Launcher ein sicheres Passwort an!**

![Profile View](/concept/media/ProfileView.png)

### Timeline
Auf dieser Ansicht können Sie Ihren Lebenslauf ablegen. Geben Sie an, was Sie am 10.10.2010 gemacht haben, oder notieren Sie hier, wann Sie Ihren Abschluss gemacht haben und welche Projekte Sie wann erfolgreich abgeschlossen haben.

![Timeline View](/concept/media/TimeLineView.png)

### Socials
Die Socials Ansicht wurde für das Wigdet "Social Widget" gebaut. Geben Sie hier alle Socials an und hinterlegen Sie ein schönes Icon von Font-Awsome! Die Socials werden dann im Footer und im Widget angezeigt.

![Socials View](/concept/media/SocialsView.png)

### FAQ
Sie können in dieser Ansicht einsehen ob jemand ihnnen eine FAQ frage gestellt hat. Beantworten Sie die gestellten FAQs oder erstellen Sie selber FAQs.

![FAQ View](/concept/media/FAQView.png)

## Wie bearbeite ich meine Seite?
Um ihre Webseite optisch zu bearbeiten gibt es verschiedene möglichkeiten. Sie können neue Layouts / Widgets auf ihre Seite ziehen und das Design ändern.

### Layouts
Im Site Editor gibt es die möglichkeit 5 Arten von Layoutblöcken auf die Webseite hinzuzufügen.

- NoSplitLayout
- 2SplitLayout
- 3SplitLayout
- BigLeftSplitLayout
- BigRightSplitLayout

![Layout View](/concept/media/LayoutTypeViews.png)

### Widgets
Der Phaedra Site-Editor kommt mit 9 verschiedenen Widgets welche dir helfen eine eigene persönliche Webseite zu erstellen. Alle Widgets können Sie ohne Code kenntnisse benutzen.

![Widgets View](/concept/media/WidgetsView.png)

### Design
Die Design-Sektion im Site-Editor ist für Designer so etwas wie der heilige Gral. Hier können Sie alle wichtigen Änderungen an Farben, Text und Abständen vornehmen. Toben Sie sich hier aus und lassen Sie Ihren Gedanken freien Lauf.

![Design View](/concept/media/DesignView.png)

## Wie erstelle ich eine neue Seite?
Im Site-Editor können Sie auf dem Abschnitt `Seiten` eine neue Seite erstellen. Klicken Sie dafür einfach auf den Button `Neue Seite`.

![CreateNewSite View](/concept/media/CreateSiteView.png)

Danach wird sich ein PopUp öffnen wo Sie verschiedene Informationen der neu erstellten Seite geben könne. Geben Sie am besten immer einen Navigation Titel eine URL und einen Seiten Titel an.

![Create New Site PopUp](/concept/media/CreateNewSitePopUp.png)

## Wie bearbeite ich meine Web-Konfigurationen?
Wenn sie änderung an ihren Web-Konfigurationen machen wollen, gehen Sie dafür ins Backend und Gehen Sie auf den Reiter `Einstellungen`.

## Wie ändere ich mein Login Passwort?
Wenn sie änderung an ihren Login Passwort machen wollen, gehen Sie dafür ins Backend und Gehen Sie auf den Reiter `Profil`.

## Wie füge ich neue Bilder & Videos hinzu?
Wenn sie neue Medien an hinzufügen wollen, gehen Sie dafür ins Backend und Gehen Sie auf den Reiter `Dateimanager`.

## Wie erstelle ich Social Links?
Wenn sie neue Social-Links erstellen wollen, gehen Sie dafür ins Backend und Gehen Sie auf den Reiter `Socials`.

## Wie erstelle ich meine Timeline?
Wenn sie neue Timelines hinzufügen wollen, gehen Sie dafür ins Backend und Gehen Sie auf den Reiter `Timeline`.

## Wie erstelle & beantworte ich meine FAQs?
Wenn sie neue FAQs hinzufügen oder beantworten wollen, gehen Sie dafür ins Backend und Gehen Sie auf den Reiter `FAQ`.