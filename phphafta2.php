<?php
$servername = "localhost"; // veya "localhost:3306"
$username = "root";
$password = ""; // Varsayılan olarak boş

// Bağlantıyı oluştur
$conn = new mysqli($servername, $username, $password);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
