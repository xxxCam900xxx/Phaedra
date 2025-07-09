<?php
require_once '../config/database.php';

header('Content-Type: application/json; charset=utf-8');

if (
    isset(
        $_POST['website_name'],
        $_POST['website_user'],
        $_POST['website_contact'],
        $_POST['website_pwd'],
        $_POST['website_pwd_confirm']
    )
) {
    $websiteName = trim($_POST['website_name']);
    $websiteHost = trim($_POST['website_user']);
    $websiteContact = trim($_POST['website_contact']);
    $websitePwd = $_POST['website_pwd'];
    $websitePwdConfirm = $_POST['website_pwd_confirm'];

    // Passwort-Bestätigung prüfen
    if ($websitePwd !== $websitePwdConfirm) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Die Passwort-Bestätigung stimmt nicht überein.'
        ]);
        exit;
    }

    // Datei-Upload für Website-Logo prüfen und verarbeiten
    $logoPath = null;
    if (isset($_FILES['website_logo']) && $_FILES['website_logo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = $_SERVER["DOCUMENT_ROOT"] . '/upload/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $tmpName = $_FILES['website_logo']['tmp_name'];
        $filename = basename($_FILES['website_logo']['name']);
        // Eindeutigen Dateinamen erstellen, z.B. mit Zeitstempel
        $uniqueName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        $targetFile = $uploadDir . $uniqueName;

        if (move_uploaded_file($tmpName, $targetFile)) {
            $logoPath = '/upload/' . $uniqueName; // relativer Pfad für DB

            // Bild-Pfad in Images-Tabelle speichern
            $queryImage = "INSERT INTO Images (ImageURL) VALUES (?)";
            $paramsImage = [$logoPath];
            $typesImage = "s";
            $resultImage = executeStatement($queryImage, $paramsImage, $typesImage);

            if (!$resultImage) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Fehler beim Speichern des Logos in der Datenbank.'
                ]);
                exit;
            }
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Fehler beim Hochladen des Logos.'
            ]);
            exit;
        }
    }

    // Daten in 'webconfig' speichern bzw. updaten
    $queryWebconfig = "
        UPDATE WebConfig
        SET WebsiteName = ?, WebHostName = ?, WebLogoURL = ?, WebContact = ?, WebLauncherCompleted = ?
        WHERE id = 1
    ";
    $paramsWebconfig = [$websiteName, $websiteHost, $logoPath, $websiteContact, "true"];
    $typesWebconfig = "sssss";
    $resultWebconfig = executeStatement($queryWebconfig, $paramsWebconfig, $typesWebconfig);

    if (!$resultWebconfig) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Fehler beim Speichern der Webconfig.'
        ]);
        exit;
    }

    // User anlegen/aktualisieren (Username: admin)
    $hashedPwd = password_hash($websitePwd, PASSWORD_DEFAULT);

    $queryUser = "
        UPDATE Users
        SET Password = ?
        WHERE Username = 'admin'
    ";
    $paramsUser = [$hashedPwd];
    $typesUser = "s";
    $resultUser = executeStatement($queryUser, $paramsUser, $typesUser);

    if (!$resultUser) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Fehler beim Aktualisieren des Benutzer-Passworts.'
        ]);
        exit;
    }

    // Wenn alles erfolgreich war
    echo json_encode([
        'success' => true,
        'message' => 'Die Webseite und der Benutzer wurden erfolgreich aktualisiert.',
        'logo_path' => $logoPath
    ]);
    exit;
} else {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Es wurden nicht alle erforderlichen Felder übermittelt.'
    ]);
    exit;
}