<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/webconfig/getWebConfig.php';
$webConfig = getWebConfig();

// PHPMailer laden
require $_SERVER["DOCUMENT_ROOT"] . '/phpMailer/Exception.php';
require $_SERVER["DOCUMENT_ROOT"] . '/phpMailer/PHPMailer.php';
require $_SERVER["DOCUMENT_ROOT"] . '/phpMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

$subjects = [
    'Allgemeine Anfrage',
    'Technischer Support',
    'Feedback',
    'Sonstiges',
];

$errors = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Nur POST erlaubt']);
    exit;
}

if (!empty($_POST['phone'])) {
    $errors[] = 'Bot erkannt.';
}

$subject = $_POST['subject'] ?? '';
$message = trim($_POST['message'] ?? '');

if (!in_array($subject, $subjects)) {
    $errors[] = 'Ungültiger Betreff.';
}

if (empty($message)) {
    $errors[] = 'Bitte Nachricht eingeben.';
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

$email = trim($_POST['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Ungültige E-Mail-Adresse.';
}

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'mailhog'; // WICHTIG: Containername
    $mail->Port = 1025;
    $mail->SMTPAuth = false;

    $user = 'Kontaktformular - ' . $email;

    $mail->setFrom($email, $user);
    $mail->addAddress(htmlspecialchars($webConfig->WebContact)); // Empfänger (z.B. du)
    $mail->addReplyTo($email); // Antwort geht an den Benutzer

    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();

    echo json_encode(['success' => true, 'message' => 'E-Mail erfolgreich gesendet.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Mailer Fehler: ' . $mail->ErrorInfo]);
}
