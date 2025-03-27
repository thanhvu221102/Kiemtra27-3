<?php
require 'session.php';
require 'db_connect.php';

if ($_SESSION['role'] !== 'Admin') {
    die("Bạn không có quyền truy cập trang này!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maNV = $_POST['MaNV'];
    $tenNV = $_POST['TenNV'];
    $phai = $_POST['Phai'];
    $noiSinh = $_POST['NoiSinh'];
    $maPhong = $_POST['MaPhong'];
    $luong = $_POST['Luong'];

    $sql = "INSERT INTO NhanVien (MaNV, TenNV, Phai, NoiSinh, MaPhong, Luong) 
            VALUES ('$maNV', '$tenNV', '$phai', '$noiSinh', '$maPhong', $luong)";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .back-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>➕ Thêm Nhân Viên</h2>
    <form method="POST">
        <label>Mã Nhân viên:</label>
        <input type="text" name="MaNV" required>

        <label>Họ và tên:</label>
        <input type="text" name="TenNV" required>

        <label>Giới tính:</label>
        <select name="Phai">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select>

        <label>Nơi sinh:</label>
        <input type="text" name="NoiSinh" required>

        <label>Mã phòng:</label>
        <input type="text" name="MaPhong" required>

        <label>Lương:</label>
        <input type="number" name="Luong" required>

        <button type="submit" class="btn">Thêm Nhân viên</button>
    </form>
    <a href="dashboard.php" class="back-link">⬅ Quay lại</a>
</div>

</body>
</html>
