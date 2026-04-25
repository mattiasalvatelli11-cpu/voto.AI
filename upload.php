<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$voti = [8, 9, 9, 10, 10, 10];
$voto = $voti[array_rand($voti)];
$username = $_SESSION['username'];

if (!empty($_FILES['foto']['name'])) {
    $file = $_FILES['foto'];
    $est = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (in_array($est, ['jpg', 'jpeg', 'png'])) {
        $nome_file = time() . '_' . uniqid() . '.' . $est;
        $percorso = '/uploads/' . $nome_file;

        if (move_uploaded_file($file['tmp_name'], $percorso)) {
            // Salva nel log dell'admin
            $log_line = date('Y-m-d H:i:s') . " | User: $username | Foto: $nome_file | Voto: $voto\n";
            file_put_contents('/uploads/log_foto.txt', $log_line, FILE_APPEND);
            ?>
            <!DOCTYPE html>
            <html lang="it">
            <head>
                <meta charset="UTF-8">
                <title>Il tuo voto</title>
                <style>
                    * { box-sizing: border-box; margin: 0; padding: 0; }
                    body { font-family: Arial; background: linear-gradient(135deg, #fff0f5, #ffe4e1); min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 30px; text-align: center; }
                    h1 { color: #ff69b4; font-size: 2.5em; margin-bottom: 10px; }
                    .voto { font-size: 6em; color: #ff1493; font-weight: bold; margin: 20px 0; }
                    img { max-width: 85%; border-radius: 20px; margin: 20px 0; box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
                    a { font-size: 1.2em; color: #d63384; text-decoration: none; margin-top: 20px; display: inline-block; }
                </style>
            </head>
            <body>
                <h1>Wow</h1>
                <div class="voto"><?= $voto ?> / 10</div>
                <img src="/uploads/<?= $nome_file ?>">
                <br>
                <a href="index.php">⬅ Carica un'altra foto</a>
            </body>
            </html>
            <?php
            exit;
        }
    }
}

echo "<h2 style='color:red;text-align:center;padding:40px;'>Errore: foto non caricata. Solo JPG e PNG!</h2>";
echo "<a href='index.php' style='display:block;text-align:center;font-size:1.3em;'>Torna indietro</a>";