<?php
$servername = "localhost";  // Server mặc định là localhost
$username = "root";         // Username mặc định trong XAMPP
$password = "";             // Mặc định MySQL của XAMPP không có mật khẩu
$database = "QL_NhanSu";    // Tên cơ sở dữ liệu

// Kết nối MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
