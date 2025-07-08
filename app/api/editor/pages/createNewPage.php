<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

$input = json_decode(file_get_contents("php://input"), true);
if (!isset($input["meta_description"], $input["meta_title"], $input["pathURL"], $input["title"])) {
    exit;
}

$meta_description = $input["meta_description"];
$meta_title = $input["meta_title"];
$pathURL = $input["pathURL"];
$title = $input["title"];

$stmt = "INSERT INTO Pages (Titel, PathURL, Meta_Description, Meta_Title) VALUES (?,?,?,?)";
$param = [$title, $pathURL, $meta_description, $meta_title];
$types = "ssss";
$insertStmt = executeStatement($stmt, $param, $types);
$newPageID = $insertStmt->insert_id;

$stmt2 = "INSERT INTO PageContent (PageID) VALUES (?)";
$param2 = [$newPageID];
$types2 = "i";
$insertStmt2 = executeStatement($stmt2, $param2, $types2);

echo json_encode([
    'success' => true,
]);