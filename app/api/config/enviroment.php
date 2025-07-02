<?php

// Database credentials
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));

define('ENCRYPTION_IV', getenv('ENCRYPTION_IV'));
define('ENCRYPTION_KEY', getenv('ENCRYPTION_KEY'));

if (empty(DB_HOST) || empty(DB_USER) || empty(DB_PASS) || empty(DB_NAME)) {
    die('Fehler: Datenbankverbindungsinformationen nicht gesetzt.');
}
if (empty(ENCRYPTION_IV) || empty(ENCRYPTION_KEY)) {
    die('Fehler: Verschlüsselungsinformationen nicht gesetzt.');
}
