<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';

header('Content-Type: application/json');

// JSON auslesen
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !is_array($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Ungültige Eingabedaten.']);
    exit;
}

// Felder extrahieren und validieren (optional: Farben prüfen etc.)
$primary      = $data['Primary_Color']      ?? null;
$secondary    = $data['Secondary_Color']    ?? null;
$background   = $data['Background_Color']   ?? null;
$footercolor   = $data['Footer_Color']   ?? null;
$h1size       = $data['Heading1_Size']        ?? null;
$h1weight     = $data['Heading1_Weight']      ?? null;
$h2size       = $data['Heading2_Size']        ?? null;
$h2weight     = $data['Heading2_Weight']      ?? null;
$psize        = $data['Paragraph_Size'] ?? null;
$pweight      = $data['Paragraph_Weight']   ?? null;
$linkColor    = $data['Link_Color']         ?? null;
$linkHover    = $data['LinkHover_Color']    ?? null;

// Existiert schon ein Eintrag?
$checkStmt = executeStatement("SELECT ID FROM WebDesign LIMIT 1");
$exists = $checkStmt->fetch();
$checkStmt->close();

if ($exists) {
    // Update bestehenden Eintrag (ID = 1)
    $stmt = executeStatement(
        "UPDATE WebDesign SET 
            Primary_Color = ?, 
            Secondary_Color = ?, 
            Background_Color = ?, 
            Footer_Color = ?,
            Heading1_Size = ?, 
            Heading1_Weight = ?, 
            Heading2_Size = ?, 
            Heading2_Weight = ?, 
            Paragraph_Size = ?, 
            Paragraph_Weight = ?, 
            Link_Color = ?, 
            LinkHover_Color = ?
         WHERE ID = 1",
        [
            $primary,
            $secondary,
            $background,
            $footercolor,
            $h1size,
            $h1weight,
            $h2size,
            $h2weight,
            $psize,
            $pweight,
            $linkColor,
            $linkHover
        ],
        "ssssssssssss"
    );
} else {
    // Neu einfügen
    $stmt = executeStatement(
        "INSERT INTO WebDesign (
            Primary_Color, Secondary_Color, Background_Color, Footer_Color,
            Heading1_Size, Heading1_Weight,
            Heading2_Size, Heading2_Weight,
            Paragraph_Size, Paragraph_Weight,
            Link_Color, LinkHover_Color
        ) VALUES (?, ?, ?, ?, ?, ? ?, ?, ?, ?, ?, ?)",
        [
            $primary,
            $secondary,
            $background,
            $footercolor,
            $h1size,
            $h1weight,
            $h2size,
            $h2weight,
            $psize,
            $pweight,
            $linkColor,
            $linkHover
        ],
        "ssssssssssss"
    );
}

if ($stmt) {
    echo json_encode(['success' => true, 'message' => 'Design erfolgreich gespeichert.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Fehler beim Speichern des Designs.']);
}
