<?php
$voti_alti = [8, 9, 9, 10, 10, 10];
$voto = $voti_alti[array_rand($voti_alti)];

if (!empty($_FILES['foto']['name'])) {
    $file = $_FILES['foto'];
    $est = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (in_array($est, ['jpg','jpeg','png'])) {
        $nome_file = time() . '_' . uniqid() . '.' . $est;
        $percorso = '/uploads/' . $nome_file;

        if (move_uploaded_file($file['tmp_name'], $percorso)) {
            echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Il tuo voto!</title>
                  <style>body{font-family:Arial;text-align:center;background:#fff0f5;padding:60px;}
                  h1{color:#ff69b4;font-size:3em;} .voto{font-size:6em;color:#ff1493;}
                  img{max-width:85%;border-radius:15px;margin:30px 0;}</style></head><body>
                  <h1>Wow! Sei proprio stupendə! 💖</h1>
                  <div class='voto'>$voto / 10</div>
                  <img src='/uploads/$nome_file'>
                  <br><br><a href='index.php' style='font-size:1.5em;color:#d63384;'>Carica un'altra foto →</a>
                  </body></html>";
            exit;
        }
    }
}
echo "<h2 style='color:red'>Errore: foto non caricata</h2>";
echo "<a href='index.php'>Torna indietro</a>";