<?php
require 'session.php';
require 'db_connect.php';

if ($_SESSION['role'] !== 'Admin') {
    die("Bạn không có quyền truy cập trang này!");
}

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

// Nếu nhấn nút xác nhận xóa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $delete_sql = "DELETE FROM NhanVien WHERE MaNV='$maNV'";

    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Xóa nhân viên thành công!'); window.location='dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Lỗi khi xóa nhân viên!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa Nhân Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
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
            text-align: center;
        }
        h2 {
            color: #dc3545;
        }
        p {
            font-size: 16px;
            color: #333;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 15px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
            border: none;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .btn-cancel {
            background: #6c757d;
            color: white;
            margin-left: 10px;
        }
        .btn-cancel:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>⚠ Xác nhận xóa</h2>
    <p>Bạn có chắc chắn muốn xóa nhân viên <strong><?= $nhanVien['TenNV'] ?></strong> không?</p>
    
    <form method="POST">
        <button type="submit" class="btn btn-danger">🗑 Xóa</button>
        <a href="dashboard.php" class="btn btn-cancel">❌ Hủy</a>
    </form>
</div>

</body>
</html>
