<?php

$password_admin = 'mattia';

if (!isset($_GET['p']) || $_GET['p'] !== $password_admin) {
    die("<h1 style='color:red;text-align:center;margin:120px;'>ACCESSO NEGATO<br>Usa ?p=mattia alla fine dell'URL</h1>");
}

$host     = getenv('MYSQL_HOST')     ?: die('Manca host DB');
$dbname   = getenv('MYSQL_DATABASE') ?: die('Manca nome DB');
$user     = getenv('MYSQL_USER')     ?: die('Manca utente DB');
$pass     = getenv('MYSQL_PASSWORD') ?: die('Manca password DB');

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);

if (isset($_GET['approva'])) $pdo->prepare("UPDATE foto SET stato='approvato' WHERE id=?")->execute([(int)$_GET['approva']]);
if (isset($_GET['cancella'])) $pdo->prepare("DELETE FROM foto WHERE id=?")->execute([(int)$_GET['cancella']]);

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Admin – Voti Alti 💖</title>
    <style>
        body{font-family:Arial;background:#f9f9f9;padding:25px;}
        h1{text-align:center;color:#ff69b4;}
        .card{background:white;margin:20px auto;padding:20px;max-width:800px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.08);}
        img{max-width:100%;border-radius:10px;}
        .actions a{margin-right:25px;font-weight:bold;font-size:1.1em;text-decoration:none;}
        .approva{color:#28a745;}
        .cancella{color:#dc3545;}
    </style>
</head>
<body>
    <h1>Area Admin – Tutte le foto belle 🌸</h1>

    <?php
    $result = $pdo->query("SELECT * FROM foto ORDER BY created_at DESC");
    if ($result->rowCount() == 0) {
        echo "<p style='text-align:center;color:#777;font-size:1.3em;'>Ancora nessuna foto caricata 💕</p>";
    }
    while ($row = $result->fetch()) {
        echo "<div class='card'>";
        echo "<img src='/uploads/" . htmlspecialchars($row['filename']) . "' alt='foto utente'><br><br>";
        echo "<b>Voto dato:</b> <span style='color:#ff1493;font-size:1.6em;'>" . $row['voto'] . " / 10</span><br>";
        echo "<b>Quando:</b> " . $row['created_at'] . "<br>";
        echo "<b>Username TikTok finto:</b> " . htmlspecialchars($row['username_tiktok']) . "<br>";
        if ($row['stato'] == 'approvato') {
            echo "<p style='color:#28a745;font-weight:bold;'>Approvata ✅</p>";
        } else {
            echo "<div class='actions'>";
            echo "<a class='approva' href='?p=mattia&approva=" . $row['id'] . "'>✅ Approva</a> ";
            echo "<a class='cancella' href='?p=mattia&cancella=" . $row['id'] . "'>❌ Cancella</a>";
            echo "</div>";
        }
        echo "</div>";
    }
    ?>
</body>
</html>