<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nisa Sakınmaz - BTE311 PHP Görevleri</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin: 50px auto;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .file-list {
            display: flex;
            flex-direction: column; /* Alt alta sıralama */
            gap: 10px;
            align-items: center; /* Ortalamak için */
        }
        .file-card {
            width: 80%; /* Butonları daha dar yaparak ekrana ortalayın */
            text-align: center;
            background: #f5f5f5;
            border-radius: 10px;
            padding: 10px;
            transition: all 0.3s ease-in-out;
            text-decoration: none;
            color: #212529;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        .file-card:hover {
            background: #007bff;
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        }
        select {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Bootstrap Card -->
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Nisa Sakınmaz - BTE311 PHP Görevleri</h1>
               

                <!-- Sıralama Seçeneği -->
                <div class="d-flex justify-content-center">
                    <select id="sort-option" class="form-select w-50" onchange="sortFiles()">
                        <option value="name">İsimle Sırala</option>
                        <option value="size">Boyutla Sırala</option>
                        <option value="date">Tarihe Göre Sırala</option>
                    </select>
                </div>

                <!-- Dosya Listesi -->
                <div class="file-list mt-4" id="file-list">
                    <?php
                    // Bulunduğunuz dizindeki dosyaları listele
                    $directory = __DIR__;
                    $files = array_diff(scandir($directory), array('.', '..', 'index.php'));

                    // Dosya bilgilerini al
                    $fileInfo = [];
                    foreach ($files as $file) {
                        $fileInfo[] = [
                            'name' => $file,
                            'size' => filesize($directory . '/' . $file),
                            'date' => filemtime($directory . '/' . $file)
                        ];
                    }

                    // Varsayılan sıralama: İsimle Sıralama
                    usort($fileInfo, function($a, $b) {
                        return strcmp($a['name'], $b['name']);
                    });

                    // Dosya listesine ekle
                    foreach ($fileInfo as $file) {
                        echo '<a class="file-card" href="' . $file['name'] . '">' . $file['name'] . '</a>';
                    }

                    // Görev 3 bağlantısını manuel ekleyin
                    echo '<a class="file-card" href="gorev3.php">Görev 3<br>Detaylar için tıklayın</a>';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Javascript -->
    <script>
        // Dosyaları sıralamak için fonksiyon
        function sortFiles() {
            const sortOption = document.getElementById('sort-option').value;
            const fileList = document.getElementById('file-list');
            const files = Array.from(fileList.getElementsByClassName('file-card'));
            
            files.sort((a, b) => {
                if (sortOption === 'name') {
                    return a.textContent.trim().localeCompare(b.textContent.trim());
                } else if (sortOption === 'size') {
                    return a.getAttribute('data-size') - b.getAttribute('data-size');
                } else if (sortOption === 'date') {
                    return a.getAttribute('data-date') - b.getAttribute('data-date');
                }
            });
            
            // Sıralanmış dosyaları yeniden ekle
            files.forEach(file => fileList.appendChild(file));
        }
    </script>
</body>
</html>
