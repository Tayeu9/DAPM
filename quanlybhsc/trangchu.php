<?php 
    session_start();

   
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }
    $username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="css/trangchu.css?v= <?php echo time() ?>">
</head>

<body>
    <header>
        <nav>
            <ul class="main-menu">
                <li><a href="trangchu.php">Trang Chủ</a></li>
                <li><a href="#">Giới Thiệu</a></li>
                <li><a href="#">Dịch Vụ</a></li>
                <li><a href="#">Liên Hệ</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <aside class="sidebar">
            <ul class="side-menu">
                <div class="thongtin">
                    <img src="https://tse4.mm.bing.net/th?id=OIP.ZDFiKU-_rlxOKiv7TNeOgwHaHa&pid=Api&P=0&h=220"
                        alt="Admin">
                    <div class="thongtin2">Khách hàng</div>
                    <div class="thongtin2"><?php echo $username; ?></div>
                </div>
                <li><a href="#">Thông tin cá nhân</a></li>
                <li><a href="#">Sản phẩm của bạn</a></li>
                <li><a href="#">Cập nhật thông tin</a></li>
                <li><a href="logout.php">Đăng xuất</a></li>
            </ul>
        </aside>
        <main>
            <div class="button-container">
                <tr onclick=""></tr>
                <button class="large-button" onclick="window.location.href='dkisuachua.php'"><img src="img/lich.png">Đặt
                    lịch</button>
                <button class="large-button"><img src="img/wallet.png">Thanh toán</button>
                <button class="large-button"><img src="img/his.png">Lịch sử</button>
                <button class="large-button" onclick="window.location.href='nhantin.php'"><img
                        src="./img/CSKH2.png">Nhắn
                    tin</button>
                <button class="large-button"><img src="img/book.png">Xem hướng dẫn</button>
                <button class="large-button"><img src="img/setting.png">Cài đặt</button>
            </div>
        </main>
    </div>
    <div class="ft">

    </div>
</body>

</html>
<?php 
    // if (!isset($_SESSION['username'])) {
    //     header("Location:login.php");
    //     exit;
    // }
?>