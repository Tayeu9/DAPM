<?php
include 'config.php';

if (isset($_GET['id'])) {
    $maNV = $_GET['id']; 

    $sql = "SELECT * FROM NhanVien WHERE MaNV = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maNV);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/chitiet.css">
    <title>Chi Tiết Nhân Viên</title>
</head>

<body>
    <header>
        <nav>
            <ul class="main-menu">
                <li><a href="#">Trang Chủ</a></li>
                <li><a href="#">Giới Thiệu</a></li>
                <li><a href="#">Dịch Vụ</a></li>
                <li><a href="#">Liên Hệ</a></li>
            </ul>
        </nav>
    </header>
    <div class="frame">
        <aside class="sidebar">
            <ul class="side-menu">
                <div class="thongtin">
                    <img src="https://tse4.mm.bing.net/th?id=OIP.ZDFiKU-_rlxOKiv7TNeOgwHaHa&pid=Api&P=0&h=220">
                    <div class="thongtin2">ADMIN</div>
                    <div class="thongtin2">ID:AM001</div>
                </div>
                <li><a href="#">Quản Lý NV</a></li>
                <li><a href="#">Quản Lý KH</a></li>
                <li><a href="#">Quản Lý TK</a></li>
                <li><a href="#">Quản lý SP</a></li>
            </ul>
        </aside>
        <main>
            <div class="container">
                <h2>Chi tiết nhân viên</h2>
                <br><br>
                <div class="khung">
                    <div class="anh">
                        <img src="<?php echo $row['hinh_anh']; ?>">
                    </div>
                    <div class="thongtinchitiet">
                        <table>
                            <tr>
                                <td><b>Mã nhân viên</b></td>
                                <td class="noidung"><?php echo $row['MaNV']; ?></td>
                                <td><img src="img/facebook.png"></td>
                            </tr>
                            <tr>
                                <td><b>Họ và tên</b></td>
                                <td class="noidung"><?php echo $row['TenNV']; ?></td>
                                <td><img src="img/zalo.png"></td>
                            </tr>
                            <tr>
                                <td><b>Chức vụ</b></td>
                                <td class="noidung"><?php echo $row['ChucVu']; ?></td>

                            </tr>
                            <tr>
                                <td><b>Quê quán</b></td>
                                <td class="noidung"><?php echo $row['DiaChi']; ?></td>
                            </tr>
                            <tr>
                                <td><b>Số điện thoại</b></td>
                                <td class="noidung"><?php echo $row['SDT']; ?></td>
                            </tr>
                            <tr>
                                <td><b>Email</b></td>
                                <td class="noidung"><?php echo $row['Email']; ?></td>
                            </tr>

                            <tr>
                                <td> <button>Trở lại</button>
                                </td>
                                <td></td>
                                <td><button>Tiếp</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>

<?php
    } else {
        echo "Không tìm thấy nhân viên.";
    }
    $stmt->close();
} else {
    echo "ID không hợp lệ.";
}

$conn->close();
?>