<?php
// Veritabanı bağlantısı
$servername = "localhost";  // Sunucu adı
$username = "root";         // PHPMyAdmin kullanıcı adı (genellikle root)
$password = "";             // PHPMyAdmin şifresi (genellikle boş)
$dbname = "anket";          // Veritabanı adı

// Veritabanına bağlanıyoruz
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Eğer formdan veri gönderildiyse
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cevap'])) {
    $cevap = $_POST['cevap']; // Evet veya Hayır cevabını alıyoruz
    
    // Veriyi veritabanına ekliyoruz
    $stmt = $conn->prepare("INSERT INTO cevaplar (cevap) VALUES (?)");
    $stmt->bind_param("s", $cevap); // Parametreyi bağlıyoruz
    $stmt->execute(); // Veriyi kaydediyoruz
    $stmt->close(); // Bağlantıyı kapatıyoruz
}

// Anket sonuçlarını alıyoruz
$evet_sayisi = $conn->query("SELECT COUNT(*) FROM cevaplar WHERE cevap='evet'")->fetch_row()[0];
$hayir_sayisi = $conn->query("SELECT COUNT(*) FROM cevaplar WHERE cevap='hayir'")->fetch_row()[0];
$toplam = $evet_sayisi + $hayir_sayisi;

// Yüzdeleri hesaplıyoruz
$evet_yuzde = $toplam > 0 ? round(($evet_sayisi / $toplam) * 100) : 0;
$hayir_yuzde = $toplam > 0 ? round(($hayir_sayisi / $toplam) * 100) : 0;

$conn->close(); // Veritabanı bağlantısını kapatıyoruz
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anket Sayfası</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
			background-color: #f0f8ff;
        }
        .container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .card {
            width: 300px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .result {
            margin-top: 20px;
			
			}
        /* Buton rengini mavi yapıyoruz */
        .btn-success {
            background-color: #007bff; /* Mavi renk */
            border-color: #007bff;
        }
        .btn-success:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h3>Oy Vermek İster Misiniz?</h3>
            <form method="POST">
                <button name="cevap" value="evet" class="btn btn-success">Evet</button>
                <button name="cevap" value="hayir" class="btn btn-danger">Hayır</button>
            </form>

            <hr>
            
            <h4>Sonuçlar:</h4>
            <div class="result">
                <p id="evet-sonuc">Evet: <?php echo $evet_sayisi; ?> kişi (<?php echo $evet_yuzde; ?>%)</p>
                <p id="hayir-sonuc">Hayır: <?php echo $hayir_sayisi; ?> kişi (<?php echo $hayir_yuzde; ?>%)</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // JavaScript ile sonuçları dinamik olarak güncellemek
        document.addEventListener('DOMContentLoaded', function() {
            // 5 saniyede bir sonuçları güncelle
            setInterval(fetchResults, 5000);
        });

        // Sonuçları çekmek için AJAX
        function fetchResults() {
            fetch('anket.php')
                .then(response => response.text())
                .then(data => {
                    // Sonuçları sayfada güncelle
                    document.getElementById('evet-sonuc').innerText = 'Evet: ' + data.match(/Evet: (\d+)/)[1] + ' kişi (' + data.match(/Evet: \d+ kişi \((\d+)%\)/)[1] + '%)';
                    document.getElementById('hayir-sonuc').innerText = 'Hayır: ' + data.match(/Hayır: (\d+)/)[1] + ' kişi (' + data.match(/Hayır: \d+ kişi \((\d+)%\)/)[1] + '%)';
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
