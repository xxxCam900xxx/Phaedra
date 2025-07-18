<?php

require_once '../api/login/IsLoggedIn.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("../configs/head.php"); ?>
    <title>Phaedra - Adminberreich</title>
</head>

<body class="admin-background">

    <main class="flex flex-row h-screen">

        <!-- Navigation -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/navigation/adminNavigation.php" ?>

        <!-- Dashboard Informationen -->
        <section class="pl-[100px]"></section>

    </main>

</body>

</html>