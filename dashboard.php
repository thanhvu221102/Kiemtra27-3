<?php
require 'session.php';
require 'db_connect.php';

if ($_SESSION['role'] !== 'Admin') {
    die("Bạn không có quyền truy cập trang này!");
}

$sql = "SELECT NhanVien.MaNV, NhanVien.TenNV, NhanVien.Phai, NhanVien.NoiSinh, PhongBan.TenPhong, NhanVien.Luong 
        FROM NhanVien 
        JOIN PhongBan ON NhanVien.MaPhong = PhongBan.MaPhong";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Nhân viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            width: 90%;
            margin: auto;
            padding-top: 20px;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .navbar a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            padding: 10px;
        }
        .navbar a:hover {
            background: #0056b3;
            border-radius: 5px;
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-btn {
            padding: 6px 12px;
            margin: 3px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }
        .edit-btn {
            background: #28a745;
            color: white;
        }
        .delete-btn {
            background: #dc3545;
            color: white;
        }
        .edit-btn:hover {
            background: #218838;
        }
        .delete-btn:hover {
            background: #c82333;
        }
        .btn-add {
            display: inline-block;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .btn-add:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="navbar">
        <div>
            <a href="index.php">🏠 Trang chủ</a>
        </div>
        <div>
            <a href="logout.php">🚪 Đăng xuất (<?= $_SESSION['username'] ?>)</a>
        </div>
    </div>

    <h2>TRANG QUẢN LÝ NHÂN VIÊN</h2>

    <a href="add_employee.php" class="btn-add">➕ Thêm Nhân viên</a>

    <table>
        <tr>
            <th>Mã NV</th>
            <th>Tên Nhân Viên</th>
            <th>Giới tính</th>
            <th>Nơi Sinh</th>
            <th>Phòng</th>
            <th>Lương</th>
            <th>Hành động</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['MaNV'] ?></td>
            <td><?= $row['TenNV'] ?></td>
            <td><?= $row['Phai'] ?></td>
            <td><?= $row['NoiSinh'] ?></td>
            <td><?= $row['TenPhong'] ?></td>
            <td><?= number_format($row['Luong'], 0, ',', '.') ?> VND</td>
            <td>
                <a href="edit_employee.php?id=<?= $row['MaNV'] ?>" class="action-btn edit-btn">✏ Sửa</a>
                <a href="delete_employee.php?id=<?= $row['MaNV'] ?>" class="action-btn delete-btn" onclick="return confirm('Xóa nhân viên này?');">❌ Xóa</a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>
</div>

</body>
</html>

<?php $conn->close(); ?>
