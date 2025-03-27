<?php
require 'session.php';
require 'db_connect.php';

if ($_SESSION['role'] !== 'Admin') {
    die("Bạn không có quyền truy cập trang này!");
}

// Lấy ID nhân viên từ URL
$maNV = isset($_GET['id']) ? $_GET['id'] : '';

if (!$maNV) {
    die("Mã nhân viên không hợp lệ!");
}

// Truy vấn thông tin nhân viên
$sql = "SELECT * FROM NhanVien WHERE MaNV='$maNV'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Không tìm thấy nhân viên!");
}

$nhanVien = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenNV = $_POST['TenNV'];
    $phai = $_POST['Phai'];
    $noiSinh = $_POST['NoiSinh'];
    $maPhong = $_POST['MaPhong'];
    $luong = $_POST['Luong'];

    $update_sql = "UPDATE NhanVien SET 
                    TenNV='$tenNV', Phai='$phai', NoiSinh='$noiSinh', 
                    MaPhong='$maPhong', Luong=$luong WHERE MaNV='$maNV'";
    
    if ($conn->query($update_sql) === TRUE) {
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
    <title>Chỉnh sửa Nhân viên</title>
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
    <h2>✏ Chỉnh Sửa Nhân Viên</h2>
    <form method="POST">
        <label>Mã Nhân viên:</label>
        <input type="text" name="MaNV" value="<?= $nhanVien['MaNV'] ?>" readonly>

        <label>Họ và tên:</label>
        <input type="text" name="TenNV" value="<?= $nhanVien['TenNV'] ?>" required>

        <label>Giới tính:</label>
        <select name="Phai">
            <option value="Nam" <?= ($nhanVien['Phai'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
            <option value="Nữ" <?= ($nhanVien['Phai'] == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
        </select>

        <label>Nơi sinh:</label>
        <input type="text" name="NoiSinh" value="<?= $nhanVien['NoiSinh'] ?>" required>

        <label>Mã phòng:</label>
        <input type="text" name="MaPhong" value="<?= $nhanVien['MaPhong'] ?>" required>

        <label>Lương:</label>
        <input type="number" name="Luong" value="<?= $nhanVien['Luong'] ?>" required>

        <button type="submit" class="btn">💾 Lưu Thay Đổi</button>
    </form>
    <a href="dashboard.php" class="back-link">⬅ Quay lại</a>
</div>

</body>
</html>
