<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosya İşlemleri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000; /* Siyah arka plan */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff;
        }
        .form-container {
            background: #222; /* Daha koyu bir gri */
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .btn-purple {
            background-color: #6a0dad; /* Mor */
            color: white;
        }
        .btn-purple:hover {
            background-color: #5a009e;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1 class="mb-4">Dosya İşlemleri</h1>
        <form id="fileForm" method="POST">
            <div class="mb-3">
                <label for="message" class="form-label">Mesaj Girin</label>
                <textarea class="form-control" id="message" name="message" rows="3" placeholder="Mesajınızı buraya yazın..."></textarea>
            </div>
            <div class="d-flex justify-content-around">
                <button type="submit" class="btn btn-purple" name="action" value="save">Mesajı Kaydet</button>
                <button type="submit" class="btn btn-danger" name="action" value="clear">Dosyayı Temizle</button>
                <button type="submit" class="btn btn-primary" name="action" value="random">Rastgele Satır Getir</button>
            </div>
        </form>
        <div class="mt-4">
            <h3>Sonuç:</h3>
            <div id="result" class="alert alert-info">
                <?php
                // Dosya yolu
                $filePath = __DIR__ . '/messages.txt';

                // Dosyanın varlığını kontrol et ve yoksa oluştur
                if (!file_exists($filePath)) {
                    file_put_contents($filePath, '');
                }

                // İşlemleri kontrol et
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $action = $_POST['action'];
                    $message = $_POST['message'] ?? '';

                    if ($action === 'save' && !empty(trim($message))) {
                        // Mesajı dosyaya kaydet
                        file_put_contents($filePath, $message . PHP_EOL, FILE_APPEND);
                        echo "Mesaj başarıyla kaydedildi!";
                    } elseif ($action === 'clear') {
                        // Dosyayı temizle
                        file_put_contents($filePath, '');
                        echo "Dosya temizlendi!";
                    } elseif ($action === 'random') {
                        // Rastgele bir satır getir
                        if (file_exists($filePath) && filesize($filePath) > 0) {
                            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                            $randomLine = $lines[array_rand($lines)];
                            echo "Rastgele Satır: <strong>$randomLine</strong>";
                        } else {
                            echo "Dosyada hiç veri bulunmuyor.";
                        }
                    } else {
                        echo "Lütfen geçerli bir işlem yapın.";
                    }
                }
                ?>
            </div>
            <p class="mt-3 text-muted">Dosya yolu: <strong><?php echo $filePath; ?></strong></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
