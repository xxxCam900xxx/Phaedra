<?php
// Session und Cookies entfernen
setcookie('session_key', '', time() - 3600, '/');
session_start();
session_unset();
session_destroy();

// Weiterleitung zur Login-Seite
header('Location: /admin/login');
exit;