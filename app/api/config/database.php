<?php

function executeStatement($query, $params = [], $types = "")
{
    $conn = getConnection();

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8'));
    }

    if (!empty($params)) {
        if ($types === "") {
            $types = str_repeat("s", count($params));
        }
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $stmt->store_result();
    return $stmt;
}

function getConnection()
{
    require_once 'enviroment.php';
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        $conn->close();
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
