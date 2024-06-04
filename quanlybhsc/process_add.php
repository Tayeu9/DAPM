<?php
include 'config.php'; // Kết nối đến cơ sở dữ liệu

// Kiểm tra xem người dùng đã gửi yêu cầu thêm nhân viên hay chưa
if(isset($_POST['MaNV'], $_POST['TenNV'], $_POST['ChucVu'], $_POST['Email'], $_POST['SDT'], $_POST['DiaChi'])) {
    // Lấy dữ liệu được gửi từ form
    $MaNV = $_POST['MaNV'];
    $TenNV = $_POST['TenNV'];
    $ChucVu = $_POST['ChucVu'];
    $Email = $_POST['Email'];
    $SDT = $_POST['SDT'];
    $DiaChi = $_POST['DiaChi'];
    
    $hinh_hanh = $_FILES['hinh_hanh']['name'];
    $temp_name = $_FILES['hinh_hanh']['tmp_name'];
    $target_dir = "img/"; 
    $target_file = $target_dir.basename($hinh_hanh);
    $allowUpload   = true;
    
    move_uploaded_file($temp_name, $target_file);
    // Tạo mật khẩu ngẫu nhiên
    function generateRandomPassword($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomPassword;
    }

    $randomPassword = generateRandomPassword();
   
    $conn->begin_transaction();

    try {
        // Thêm tài khoản vào cơ sở dữ liệu (sử dụng MaNV làm TenTaiKhoan)
        $loaiTaiKhoan = 'NV'; // Loại tài khoản là nhân viên
        $sqlTaiKhoan = "INSERT INTO taikhoan (TenTaiKhoan, MatKhau, LoaiTaiKhoan) 
                        VALUES ('$MaNV', '$randomPassword', '$loaiTaiKhoan')";
        if (!$conn->query($sqlTaiKhoan)) {
            throw new Exception("Lỗi khi thêm tài khoản: " . $conn->error);
        }

        // Thêm nhân viên vào cơ sở dữ liệu
        $sqlNhanVien = "INSERT INTO nhanvien (MaNV, TenNV, ChucVu, Email, SDT, DiaChi, TenTaiKhoan, hinh_anh) 
                        VALUES ('$MaNV', '$TenNV', '$ChucVu', '$Email', '$SDT', '$DiaChi', '$MaNV', '$target_file')";
        if (!$conn->query($sqlNhanVien)) {
            throw new Exception("Lỗi khi thêm nhân viên: " . $conn->error);
        }

        // Cam kết giao dịch nếu mọi thứ thành công
        $conn->commit();

        // Chuyển hướng sau khi thêm thành công
        header('Location: trangquanly.php'); 
        exit;

    } catch (Exception $e) {
        // Hoàn tác giao dịch nếu có lỗi
        $conn->rollback();
        echo "Đã xảy ra lỗi: " . $e->getMessage();
    }
} else {
    // Nếu không có dữ liệu được gửi, hiển thị thông báo lỗi
    echo ('giống như trước');
}

// Đóng kết nối đến cơ sở dữ liệu
$conn->close();
?>