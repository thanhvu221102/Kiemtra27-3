<?php
require 'db_connect.php';
session_start();

// Số nhân viên mỗi trang
$limit = 5;

// Xác định trang hiện tại
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Truy vấn dữ liệu với giới hạn và phân trang
$sql = "SELECT NhanVien.MaNV, NhanVien.TenNV, NhanVien.Phai, NhanVien.NoiSinh, PhongBan.TenPhong, NhanVien.Luong 
        FROM NhanVien 
        JOIN PhongBan ON NhanVien.MaPhong = PhongBan.MaPhong 
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Đếm tổng số nhân viên
$total_sql = "SELECT COUNT(*) AS total FROM NhanVien";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Nhân Viên</title>
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
        img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a {
            padding: 8px 15px;
            margin: 3px;
            border-radius: 5px;
            text-decoration: none;
            background: #007bff;
            color: white;
            font-weight: bold;
        }
        .pagination a.active {
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
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="login.php">🔑 Đăng nhập</a>
                <a href="register.php">📝 Đăng ký</a>
            <?php else: ?>
                <a href="logout.php">🚪 Đăng xuất (<?= $_SESSION['username'] ?>)</a>
            <?php endif; ?>
        </div>
    </div>

    <h2>THÔNG TIN NHÂN VIÊN</h2>

    <table>
        <tr>
            <th>Mã NV</th>
            <th>Tên Nhân Viên</th>
            <th>Giới tính</th>
            <th>Nơi Sinh</th>
            <th>Tên Phòng</th>
            <th>Lương</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['MaNV'] ?></td>
            <td><?= $row['TenNV'] ?></td>
            <td>
                <?php
                $gender_image = ($row['Phai'] == 'Nữ') ? 'woman.jpg' : 'man.jpg';
                echo "<img src='images/$gender_image' alt='{$row['Phai']}'>";
                ?>
            </td>
            <td><?= $row['NoiSinh'] ?></td>
            <td><?= $row['TenPhong'] ?></td>
            <td><?= number_format($row['Luong'], 0, ',', '.') ?> VND</td>
        </tr>
        <?php endwhile; ?>

    </table>

    <!-- Phân trang -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
