<?php
include 'config.php';

if (isset($_GET['id'])) {
    $maNV = $_GET['id']; // Sử dụng mã nhân viên thay vì id

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Xóa thông tin nhân viên từ bảng NhanVien
        $sqlNhanVien = "DELETE FROM nhannien WHERE MaNV = ?";
        $stmtNhanVien = $conn->prepare($sqlNhanVien);
        $stmtNhanVien->bind_param("s", $maNV);

        if (!$stmtNhanVien->execute()) {
            throw new Exception("Lỗi khi xóa nhân viên.");
        }
        // Xóa thông tin tài khoản từ bảng TaiKhoan
        $sqlTaiKhoan = "DELETE FROM TaiKhoan WHERE TenTaiKhoan = ?";
        $stmtTaiKhoan = $conn->prepare($sqlTaiKhoan);
        $stmtTaiKhoan->bind_param("s", $maNV);

        if (!$stmtTaiKhoan->execute()) {
            throw new Exception("Lỗi khi xóa tài khoản.");
        }

        // Hoàn tất giao dịch
        $conn->commit();

        // Chuyển hướng đến trang chính
        header('Location: trangquanly.php');
        exit;

    } catch (Exception $e) {
        // Hủy bỏ giao dịch nếu có lỗi
        $conn->rollback();
        echo $e->getMessage();
    }

    // Đóng các statement
    $stmtNhanVien->close();
    $stmtTaiKhoan->close();
} else {
    echo "Mã nhân viên không hợp lệ.";
}

// Đóng kết nối đến cơ sở dữ liệu
$conn->close();
?>