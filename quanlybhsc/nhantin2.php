<?php
session_start();

// Include file kết nối cơ sở dữ liệu
include("config.php");


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['username'];

// Xử lý việc gửi tin nhắn
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = $_POST['message'];

    // Lấy MaKH từ bảng KhachHang dựa trên tên tài khoản
    $sql_get_maKH = "SELECT MaNV FROM nhanvien WHERE TenTaiKhoan = '$username'";
    $result_get_maKH = mysqli_query($conn, $sql_get_maKH);

    if (mysqli_num_rows($result_get_maKH) > 0) {
        $row_maKH = mysqli_fetch_assoc($result_get_maKH);
        $maKH = $row_maKH['MaNV'];

        // Lấy MaNV từ dữ liệu được gửi từ form
        $maNV = $_POST['receiver'];

        // Thực hiện truy vấn để lưu tin nhắn vào bảng Chat
        $sql_insert_message = "INSERT INTO Chat (MaKH, NoiDung, ThoiGian, MaNV) VALUES ('$maNV', '$message', NOW(), '$maKH')";
        if (mysqli_query($conn, $sql_insert_message)) {
            echo "Tin nhắn đã được gửi thành công.";
        } else {
            echo "Lỗi: " . $sql_insert_message . "<br>" . mysqli_error($conn);
        }
    } else {
        // Nếu không tìm thấy MaKH, không thể gửi tin nhắn
        echo "Lỗi: Không tìm thấy MaKH tương ứng với tên tài khoản '$username'.";
    }
}

// Lấy danh sách nhân viên để hiển thị trong danh sách chọn
$sql_get_employees = "SELECT MaKH, TenKH FROM khachhang";
$result_get_employees = mysqli_query($conn, $sql_get_employees);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="css/nhantin.css" rel="stylesheet">
</head>

<body>

    <h1>Chat</h1>
    <div class="welcome">Xin chào, <?php echo $username; ?> | <a href="logout.php" class="logout-btn">Đăng xuất</a>
    </div>
    <!-- Form để gửi tin nhắn -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="message">Tin nhắn:</label>
        <textarea name="message" rows="4" cols="50"></textarea><br>
        <label for="receiver">Người nhận:</label>
        <select name="receiver">
            <?php
            while ($row = mysqli_fetch_assoc($result_get_employees)) {
                echo "<option value='" . $row['MaKH'] . "'>" . $row['TenKH'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Gửi tin nhắn">
    </form>

    <h3>Các tin nhắn:</h3>
    <ul>
        <?php
        // Lấy MaKH hoặc MaNV từ CSDL tương ứng với $username
        $sql_get_user_id = "SELECT MaKH FROM KhachHang WHERE TenTaiKhoan = '$username'";
        $result_get_user_id = mysqli_query($conn, $sql_get_user_id);
        if (mysqli_num_rows($result_get_user_id) > 0) {
            $row_user_id = mysqli_fetch_assoc($result_get_user_id);
            $userID = $row_user_id['MaKH'];
        } else {
            $sql_get_user_id = "SELECT MaNV FROM NhanVien WHERE TenTaiKhoan = '$username'";
            $result_get_user_id = mysqli_query($conn, $sql_get_user_id);
            if (mysqli_num_rows($result_get_user_id) > 0) {
                $row_user_id = mysqli_fetch_assoc($result_get_user_id);
                $userID = $row_user_id['MaNV'];
            } else {
                echo "Không tìm thấy người dùng tương ứng.";
                exit;
            }
        }

        // Truy vấn tin nhắn từ bảng Chat
        $sql_get_messages = "SELECT * FROM Chat WHERE MaNV = '$userID' OR MaKH = '$userID' ORDER BY ThoiGian ASC";
        $result_get_messages = mysqli_query($conn, $sql_get_messages);
        $messages_by_sender = array();
        if (mysqli_num_rows($result_get_messages) > 0) {
            // while ($row = mysqli_fetch_assoc($result_get_messages)) {
            //     $senderID = $row['MaKH']; // ID của người gửi tin nhắn
            //     $receiverID = $row['MaNV']; // ID của người nhận tin nhắn
                
            //     // Xác định tên của người gửi dựa trên ID
            //     $senderName = '';
            //     if (!empty($senderID)) {
            //         $sql_get_sender_name = "SELECT TenKH FROM KhachHang WHERE MaKH = '$senderID'";
            //         $result_get_sender_name = mysqli_query($conn, $sql_get_sender_name);
            //         if (mysqli_num_rows($result_get_sender_name) > 0) {
            //             $row_sender_name = mysqli_fetch_assoc($result_get_sender_name);
            //             $senderName = $row_sender_name['TenKH'];
            //         }
            //     } else if (!empty($receiverID)) {
            //         $sql_get_sender_name = "SELECT TenNV FROM NhanVien WHERE MaNV = '$receiverID'";
            //         $result_get_sender_name = mysqli_query($conn, $sql_get_sender_name);
            //         if (mysqli_num_rows($result_get_sender_name) > 0) {
            //             $row_sender_name = mysqli_fetch_assoc($result_get_sender_name);
            //             $senderName = $row_sender_name['TenNV'];
            //         }
            //     }
        
            //     echo "<li>" . $senderName . ": " . $row["NoiDung"] . " - " . $row["ThoiGian"] . "</li>";
            //}
            while ($row = mysqli_fetch_assoc($result_get_messages)) {
                $senderID = $row['MaNV'] ?? $row['MaKH']; // Lấy ID của người gửi (MaNV hoặc MaKH)
                $senderName = ''; // Tên của người gửi
        
                // Lấy tên của người gửi dựa trên ID
                if (!empty($row['MaKH'])) {
                    $sql_get_sender_name = "SELECT TenKH FROM KhachHang WHERE MaKH = '{$row['MaKH']}'";
                    $result_get_sender_name = mysqli_query($conn, $sql_get_sender_name);
                    if (mysqli_num_rows($result_get_sender_name) > 0) {
                        $row_sender_name = mysqli_fetch_assoc($result_get_sender_name);
                        $senderName = $row_sender_name['TenKH'];
                    }
                } elseif (!empty($row['MaNV'])) {
                    $sql_get_sender_name = "SELECT TenNV FROM NhanVien WHERE MaNV = '{$row['MaNV']}'";
                    $result_get_sender_name = mysqli_query($conn, $sql_get_sender_name);
                    if (mysqli_num_rows($result_get_sender_name) > 0) {
                        $row_sender_name = mysqli_fetch_assoc($result_get_sender_name);
                        $senderName = $row_sender_name['TenNV'];
                    }
                }
        
                // Lưu tin nhắn vào mảng theo người gửi
                $messages_by_sender[$senderName][] = $row;
            }
        
            // Hiển thị tin nhắn của từng nhóm theo cách mong muốn
            foreach ($messages_by_sender as $senderName => $messages) {
                echo "<h3>$senderName:</h3>";
                echo "<ul>";
                foreach ($messages as $message) {
                    echo "<li>" . $message["NoiDung"] . " - " . $message["ThoiGian"] . "</li>";
                }
                echo "</ul>";
            }
        } else {
            echo "<li>Không có tin nhắn.</li>";
        }
        ?>
    </ul>
</body>

</html>