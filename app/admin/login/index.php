<?php
require_once '../../api/launcher/isSetupCompleted.php';
checkWebLauncherCompleted();
require_once '../../api/config/database.php';

if (!empty($_COOKIE['session_key'])) {
    $sessionKey = $_COOKIE['session_key'];

    $stmt = executeStatement(
        "SELECT ID FROM Users WHERE SessionToken = ? AND SessionTokenExpireDate > NOW()",
        [$sessionKey],
        "s"
    );

    $stmt->bind_result($id);
    if ($stmt->fetch()) {
        $stmt->close();
        header('Location: /admin');
        exit;
    }
    $stmt->close();
}

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Bitte Benutzername und Passwort eingeben.";
    } else {
        // Nutzer aus DB holen
        $stmt = executeStatement(
            "SELECT ID, Password FROM Users WHERE Username = ?",
            [$username],
            "s"
        );
        $stmt->bind_result($id, $passwordHash);
        $stmt->fetch();
        $stmt->close();

        if ($id && password_verify($password, $passwordHash)) {
            // Login erfolgreich - Session-Key generieren
            $sessionKey = bin2hex(random_bytes(32)); // 64 Zeichen Hex
            $expire = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

            // Session-Key und Ablauf speichern
            $updateStmt = executeStatement(
                "UPDATE Users SET SessionToken = ?, SessionTokenExpireDate = ? WHERE id = ?",
                [$sessionKey, $expire, $id],
                "ssi"
            );
            $updateStmt->close();

            // Cookie setzen
            setcookie('session_key', $sessionKey, strtotime($expire), '/', '', false, true);

            // User-ID in Session speichern
            $_SESSION['user_id'] = $id;

            header('Location: /admin');
            exit;
        } else {
            $error = "Benutzername oder Passwort falsch.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <?php require("../../configs/head.php"); ?>
    <title>Phaedra - Login</title>
</head>

<body>

    <main class="h-screen flex flex-row">

        <section class="w-4/7 h-screen flex flex-col gap-10 items-center justify-center">

            <div class="flex flex-col items-center">
                <h1 class="text-6xl font-semibold">Phaedra</h1>
                <h2 class="text-3xl">Melden Sie sich ganz gemütlich an</h2>
            </div>

            <form method="post" action="" class="space-y-4 w-full max-w-lg mx-auto">
                <!-- Benutzerfeld -->
                <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2">
                    <i class="fa-solid fa-user text-emerald-400 text-3xl"></i>
                    <input
                        type="text"
                        name="username"
                        placeholder="Benutzer"
                        class="ml-2 w-full outline-none text-gray-700 placeholder-gray-400 text-2xl"
                        required
                        autocomplete="username"
                    />
                </div>

                <!-- Passwortfeld -->
                <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2">
                    <i class="fa-solid fa-lock text-emerald-400 text-3xl"></i>
                    <input
                        type="password"
                        name="password"
                        placeholder="Passwort"
                        class="ml-2 w-full outline-none text-gray-700 placeholder-gray-400 text-2xl"
                        required
                        autocomplete="current-password"
                    />
                </div>

                <?php if (!empty($error)) : ?>
                    <p class="text-red-600 font-semibold"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <button
                    type="submit"
                    class="w-full bg-emerald-400 cursor-pointer text-white font-semibold py-2 rounded hover:bg-emerald-600 transition"
                >
                    Anmelden
                </button>
            </form>

            <a class="text-emerald-400" href="/credits">Hier kommen Sie zu den Credits</a>

        </section>

        <aside class="w-3/7 h-screen bg-emerald-300 flex flex-col justify-center items-center gap-2 text-white">

            <i class="fa-solid fa-cloud text-8xl"></i>
            <h1 class="text-5xl font-semibold">Willkommen Zurück!</h1>
            <p class="text-2xl" id="quotes">Hier liegen Random Quotes</p>

        </aside>

    </main>

</body>

</html>