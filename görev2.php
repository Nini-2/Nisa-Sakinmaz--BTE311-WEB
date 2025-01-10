<?php
// Satır ve sütun sayıları formdan geldiyse, onları alıyoruz
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rows = isset($_POST['rows']) ? max(1, (int) $_POST['rows']) : 5;
    $cols = isset($_POST['cols']) ? max(1, (int) $_POST['cols']) : 5;
} else {
    $rows = 5;
    $cols = 5;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hafta 10 PHP Dinamik Tablo Yap</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #104e8b; /* Başlık rengi */
            margin-bottom: 20px;
        }
        form {
            text-align: center;
            margin-bottom: 30px;
        }
        form label {
            font-size: 1.2em;
            margin-right: 10px;
        }
        form input[type="number"] {
            width: 50px;
            padding: 5px;
            margin-right: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
        }
        form input[type="submit"] {
            padding: 8px 16px;
            font-size: 1em;
            color: white;
            background-color: #FF0000; /* Kırmızı buton */
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        form input[type="submit"]:hover {
            background-color: #b30000; /* Daha koyu kırmızı */
        }
        table {
            width: 100%;
            border-collapse: collapse; /* Çizgileri netleştir */
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: center;
            border: 2px solid #104e8b; /* Çizgilerin kalınlığını artırdık */
        }
        th {
            background-color: #4f94cd; /* Başlık arka planı: #4f94cd */
            color: white;
        }
        td {
            background-color: #eaf3fb; /* Hücre arka planı: Açık mavi */
        }
        tr:nth-child(even) td {
            background-color: #d6e9f8; /* Alternatif satır rengi */
        }
        .table-size {
            text-align: center;
            font-size: 1.2em;
            margin-top: 10px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Hafta 10 PHP Dinamik Tablo Yap</h1>
    <form method="POST" action="">
        <label for="rows">Satır Sayısı:</label>
        <input type="number" id="rows" name="rows" value="<?= $rows ?>" min="1" max="20" required>
        <label for="cols">Sütun Sayısı:</label>
        <input type="number" id="cols" name="cols" value="<?= $cols ?>" min="1" max="20" required>
        <input type="submit" value="Tabloyu Oluştur">
    </form>

    <!-- Kullanıcının girdiği tablo boyutunu yazdırıyoruz -->
    <div class="table-size">
        <?= "{$rows}x{$cols} Tablo" ?>
    </div>

    <table>
        <thead>
            <tr>
                <?php for ($i = 1; $i <= $cols; $i++): ?>
                    <th>Sütun <?= $i ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < $rows; $i++): ?>
                <tr>
                    <?php for ($j = 0; $j < $cols; $j++): ?>
                        <td><?= rand(1, 100) ?></td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>

</body>
</html>
