<?php
$password_admin = 'mattia';

if (!isset($_POST['password']) || $_POST['password'] !== $password_admin) {
    echo '<!DOCTYPE html><html lang="it"><head><meta charset="UTF-8"><title>Admin Login</title>
          <style>body{font-family:Arial;text-align:center;background:#f9f9f9;padding:80px;}
          input{padding:15px;font-size:1.2em;width:300px;}</style></head><body>
          <h1>🔐 Area Admin</h1>
          <form method="post">
              <p>Inserisci la password:</p>
              <input type="password" name="password" placeholder="Scrivi mattia" required autofocus>
              <br><br>
              <button type="submit" style="padding:12px 40px;background:#ff69b4;color:white;border:none;font-size:1.3em;border-radius:8px;">ENTRA</button>
          </form></body></html>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Admin – Tutte le foto 💖</title>
    <style>
        body {font-family:Arial;background:#f9f9f9;padding:20px;}
        h1 {text-align:center;color:#ff69b4;}
        .foto {background:white;margin:20px auto;padding:20px;max-width:750px;border-radius:15px;box-shadow:0 5px 20px rgba(0,0,0,0.1);text-align:center;}
        img {max-width:100%;border-radius:12px;}
        .delete {color:#f44336;font-weight:bold;margin-left:15px;}
    </style>
</head>
<body>
    <h1>📸 Area Admin – Foto caricate</h1>
    <p><a href=".." style="color:#ff69b4;font-size:1.2em;">← Torna alla home pubblica</a></p>

    <?php
    $files = scandir('/uploads');
    $trovate = false;
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg','jpeg','png'])) {
            $trovate = true;
            echo "<div class='foto'>";
            echo "<img src='/uploads/$file'><br><br>";
            echo "<strong>$file</strong><br>";
            echo "<a href='/uploads/$file' target='_blank' style='color:#2196F3;'>Apri immagine grande</a>";
            echo " | <a class='delete' href='?delete=$file' onclick=\"return confirm('Vuoi davvero cancellare questa foto?')\">❌ Cancella</a>";
            echo "</div>";
        }
    }
    if (!$trovate) echo "<p style='text-align:center;color:#777;font-size:1.5em;padding:50px;'>Ancora nessuna foto caricata 💕</p>";
    ?>
</body>
</html>