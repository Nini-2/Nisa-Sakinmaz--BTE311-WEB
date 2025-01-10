<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    // Veritabanı bağlantısı
    $conn = new mysqli('localhost', 'root', '', 'kullanici_sistemi');
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    // Anasayfa
    if ($page == 'home') {
    ?>
        <div class="container text-center mt-5">
            <h1>Hoş Geldiniz</h1>
            <div class="mt-4">
                <a href="?page=kayit" class="btn btn-primary">Kayıt Ol</a>
                <a href="?page=ara" class="btn btn-secondary">Kullanıcı Ara</a>
            </div>
        </div>
    <?php
    }
    // Kayıt Sayfası
    elseif ($page == 'kayit') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ad = $_POST['ad'];
            $soyad = $_POST['soyad'];
            $email = $_POST['email'];

            $stmt = $conn->prepare("INSERT INTO kullanicilar (ad, soyad, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $ad, $soyad, $email);

            if ($stmt->execute()) {
                echo "<script>alert('Kayıt başarılı!'); window.location.href = '?page=home';</script>";
            } else {
                echo "Hata: " . $stmt->error;
            }

            $stmt->close();
        }
    ?>
        <div class="container text-center mt-5">
            <h1>Kayıt Ol</h1>
            <form method="POST" class="mt-4">
                <div class="mb-3">
                    <input type="text" name="ad" class="form-control" placeholder="Adınız" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="soyad" class="form-control" placeholder="Soyadınız" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email Adresiniz" required>
                </div>
                <button type="submit" class="btn btn-primary">Kaydet</button>
            </form>
            <a href="?page=home" class="btn btn-secondary mt-3">Ana Sayfaya Dön</a>
        </div>
    <?php
    }
    // Kullanıcı Ara Sayfası
    elseif ($page == 'ara') {
    ?>
        <div class="container text-center mt-5">
            <h1>Kullanıcı Ara</h1>
            <div class="mt-4">
                <form method="GET">
                    <input type="hidden" name="page" value="ara">
                    <input type="text" name="ad" class="form-control mb-3" placeholder="Ad girin" required>
                    <button type="submit" class="btn btn-primary">Ara</button>
                </form>
            </div>
            <div class="mt-4">
                <?php
                if (isset($_GET['ad'])) {
                    $ad = $_GET['ad'];

                    $stmt = $conn->prepare("SELECT ad, soyad, email FROM kullanicilar WHERE ad = ?");
                    $stmt->bind_param("s", $ad);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $user = $result->fetch_assoc();
                        echo "<p><strong>Ad:</strong> " . $user['ad'] . "</p>";
                        echo "<p><strong>Soyad:</strong> " . $user['soyad'] . "</p>";
                        echo "<p><strong>Email:</strong> " . $user['email'] . "</p>";
                    } else {
                        echo "<p>Kullanıcı bulunamadı.</p>";
                    }

                    $stmt->close();
                }
                ?>
            </div>
            <a href="?page=home" class="btn btn-secondary mt-3">Ana Sayfaya Dön</a>
        </div>
    <?php
    }
    $conn->close();
    ?>
</body>
</html>
