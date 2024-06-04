<?php 
    session_start();

   
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }
    $username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link rel="stylesheet" href="css/style.css">
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
                    <img src="https://tse4.mm.bing.net/th?id=OIP.ZDFiKU-_rlxOKiv7TNeOgwHaHa&pid=Api&P=0&h=220"
                        alt="Admin">
                    <div class="thongtin2">ADMIN</div>
                    <div class="thongtin2">ID: <?php echo $username; ?></div>
                </div>
                <li><a href="#">Quản Lý NV</a></li>
                <li><a href="#">Quản Lý KH</a></li>
                <li><a href="#">Quản Lý TK</a></li>
                <li><a href="logout.php">Đăng xuất</a></li>
            </ul>
        </aside>
        <main>
            <div class="container">
                <h2>Quản lý nhân viên</h2>
                <div class="frames">
                    <div class="timkiem">
                        <form method="get">
                            <input class="ips" type="text" name="search" placeholder="Nhập tên nhân viên...">
                            <button class="bts tk" type="submit">Tìm kiếm</button>
                        </form>
                        <button class="bts tm" onclick="gotoadd()">Tạo mới</button>
                    </div>
                </div>
                <br><br>
                <?php
                include 'config.php'; 
                $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

                if ($search) {
                    $sql = "SELECT * FROM nhanvien WHERE TenNV LIKE '%$search%' OR MaNV LIKE '%$search%'";
                } else {
                    $sql = "SELECT * FROM nhanvien";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table border='1'>
                            <thead>
                                <tr>
                                    <th>Mã NV</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên NV</th>
                                    <th>Chức vụ</th>
                                    <th>Email</th>
                                    <th>SDT</th>
                                    <th>Địa chỉ</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>"; 
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = htmlspecialchars($row["hinh_anh"], ENT_QUOTES, 'UTF-8');
                        echo '<tr onclick="goToDetail(\'' . $row["MaNV"] . '\')">';
                        echo "<td>" . htmlspecialchars($row["MaNV"], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo '<td style="text-align: center;"><img style="height: 50px; width: 50px; display: block; margin: auto;" src="' . $imagePath . '" alt="Hình ảnh"></td>';
                        echo "<td>" . htmlspecialchars($row["TenNV"], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row["ChucVu"], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row["Email"], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row["SDT"], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row["DiaChi"], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo '<td>
                        <button class="cursor-pointer btsua"  onclick="goToEdit(event,\'' . $row["MaNV"] . '\')">Sửa</button>
                        <button class="cursor-pointer btxoa"  onclick="confirmDelete(event,\'' . $row["MaNV"] . '\')">Xóa</button>
                    </td>';
                        echo "</tr>";
                    }
                    echo "</tbody></table>"; 
                } else {
                    echo "Không có nhân viên nào.";
                }

                $conn->close();
                ?>
            </div>

        </main>
    </div>

    <script src="trangquanly.js"></script>
</body>