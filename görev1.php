<?php
echo '
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>0-100 Arası Tek Sayılar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .container {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #000; /* Siyah başlık */
            margin-bottom: 30px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(10, 1fr); /* 10 sütunlu grid düzeni */
            gap: 20px; /* Kartlar arasındaki eşit boşluk */
            justify-items: center;
        }
        li {
            font-size: 1.5em;
            background-color: #1E90FF; /* Mavi arka plan */
            color: white; /* Beyaz yazı */
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
        }
        .max-number {
            background-color: #000; /* Siyah arka plan */
            color: white; /* Beyaz yazı */
            font-size: 1.8em;
            font-weight: bold;
            transform: scale(1.3);
        }
    </style>
</head>
<body>

<div class="container">
    <h1>0-100 Arası Tek Sayılar</h1>
    <ul>';

    $max_value = 0;

    // 1'den 100'e kadar tek sayıları yazdır
    for ($i = 1; $i <= 100; $i++) {
        if ($i % 2 != 0) {
            // En büyük sayıyı bul
            if ($i > $max_value) {
                $max_value = $i;
            }
            // Sayıları normal listele
            if ($i == $max_value) {
                // En büyük sayıyı farklı stil ile yazdır
                echo "<li class='max-number'>$i</li>";
            } else {
                echo "<li>$i</li>";
            }
        }
    }

    echo '</ul>
</div>

</body>
</html>';
?>