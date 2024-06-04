<?php
session_start();
include 'config.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT taikhoan.*, khachhang.TenKH AS TenKH, nhanvien.TenNV AS TenNV 
              FROM taikhoan 
              LEFT JOIN khachhang ON taikhoan.TenTaiKhoan = khachhang.TenTaiKhoan 
              LEFT JOIN nhanvien ON taikhoan.TenTaiKhoan = nhanvien.TenTaiKhoan 
              WHERE taikhoan.TenTaiKhoan = '$username' AND taikhoan.MatKhau = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Đăng nhập thành công
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['TenTaiKhoan'];
        
       
        if ($row['LoaiTaiKhoan']=="A") {
            header("Location: trangquanly.php");
            exit;
        } elseif ($row['LoaiTaiKhoan']=="N") {
            header("Location: trangchunv.php");
            exit;
        }
        elseif ($row['LoaiTaiKhoan']=="K") {
            header("Location: trangchu.php");
            exit;
        }
         else {
            echo "Loại tài khoản không hợp lệ.";
            exit;
        }
    } else {
        // Đăng nhập không thành công
        echo "<span style=\"color: white;\">Tên đăng nhập hoặc mật khẩu không đúng.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="css/login.css">

</head>

<body>
    <h2>Đăng nhập</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>Tên đăng nhập: </div>
        <input type="text" name="username">
        <div>Mật khẩu:</div>
        <input type="password" name="password"><br>
        <a>Quên mật khẩu</a>
        <input type="submit" value="Đăng nhập">
    </form>
</body>

</html>