<?php
$password_admin = 'mattia2024';

session_start();
if (!isset($_SESSION['admin_ok'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['pwd'] === $password_admin) {
        $_SESSION['admin_ok'] = true;
    } else {
        echo '<!DOCTYPE html><html lang="it"><head><meta charset="UTF-8"><title>Admin Login</title>
        <style>body{font-family:Arial;text-align:center;background:#f5f5f5;padding:80px;}
        input{padding:14px;font-size:1.1em;width:280px;border-radius:8px;border:1px solid #ccc;}
        button{padding:14px 40px;background:#ff69b4;color:white;border:none;font-size:1.1em;border-radius:8px;cursor:pointer;margin-top:10px;}
        </style></head><body>
        <h1>🔐 Area Admin</h1>
        <form method="post">
            <input type="password" name="pwd" placeholder="Password admin" required><br><br>
            <button type="submit">Entra</button>
        </form></body></html>';
        exit;
    }
}

// Cancella foto
if (isset($_GET['delete'])) {
    $f = basename($_GET['delete']);
    $path = '/uploads/' . $f;
    if (file_exists($path)) unlink($path);
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Admin – Pannello</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; padding: 20px; }
        h1 { color: #ff69b4; text-align: center; }
        h2 { color: #555; margin-top: 40px; }
        .foto { background: white; margin: 20px auto; padding: 20px; max-width: 700px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
        img { max-width: 100%; border-radius: 12px; }
        .del { color: #f44336; font-weight: bold; cursor: pointer; }
        pre { background: #fff; padding: 20px; border-radius: 12px; max-width: 700px; margin: 20px auto; overflow-x: auto; font-size: 0.9em; border: 1px solid #eee; }
        a { color: #2196F3; }
    </style>
</head>
<body>
<h1>📊 Pannello Admin</h1>

<h2 style="text-align:center">📋 Log accessi (nickname + password inseriti)</h2>
<pre><?php
$log = '/uploads/log_accessi.txt';
echo file_exists($log) ? htmlspecialchars(file_get_contents($log)) : 'Nessun accesso ancora.';
?></pre>

<h2 style="text-align:center">📸 Log foto caricate</h2>
<pre><?php
$log2 = '/uploads/log_foto.txt';
echo file_exists($log2) ? htmlspecialchars(file_get_contents($log2)) : 'Nessuna foto ancora.';
?></pre>

<h2 style="text-align:center">🖼️ Foto caricate</h2>
<?php
$files = scandir('/uploads');
$trovate = false;
foreach ($files as $file) {
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg','jpeg','png'])) {
        $trovate = true;
        echo "<div class='foto'>
            <img src='/uploads/$file'><br><br>
            <strong>$file</strong><br>
            <a href='/uploads/$file' target='_blank'>Apri grande</a> |
            <a class='del' href='?delete=$file' onclick=\"return confirm('Cancellare questa foto?')\">❌ Cancella</a>
        </div>";
    }
}
if (!$trovate) echo "<p style='text-align:center;color:#aaa;font-size:1.3em;'>Nessuna foto caricata.</p>";
?>
</body>
</html>