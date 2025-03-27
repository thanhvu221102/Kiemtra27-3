<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Mã hóa mật khẩu
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $role = 'User'; // Mặc định là User

    // Kiểm tra username đã tồn tại chưa
    $checkUser = "SELECT * FROM User WHERE Username='$username'";
    $result = $conn->query($checkUser);

    if ($result->num_rows > 0) {
        echo "<script>alert('Tên đăng nhập đã tồn tại! Vui lòng chọn tên khác.');</script>";
    } else {
        $sql = "INSERT INTO User (Username, Password, Fullname, Email, Role) 
                VALUES ('$username', '$password', '$fullname', '$email', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Đăng ký thành công! Hãy đăng nhập.'); window.location='login.php';</script>";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-register {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-register:hover {
            background: #0056b3;
        }
        .login-link {
            margin-top: 15px;
            display: block;
            color: #28a745;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Đăng ký tài khoản</h2>
        <form method="POST">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="input-group">
                <label>Họ và tên</label>
                <input type="text" name="fullname" required>
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <button type="submit" class="btn-register">Đăng ký</button>
        </form>
        <a href="login.php" class="login-link">Đã có tài khoản? Đăng nhập ngay</a>
    </div>

</body>
</html>
