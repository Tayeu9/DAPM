<?php
include 'config.php'; 

if (isset($_POST['MaNV'], $_POST['TenNV'], $_POST['ChucVu'], $_POST['Email'], $_POST['SDT'], $_POST['DiaChi'])) {

    $MaNV = $_POST['MaNV'];
    $TenNV = $_POST['TenNV'];
    $Email = $_POST['Email'];
    $SDT = $_POST['SDT'];
    $DiaChi = $_POST['DiaChi'];
    $ChucVu = $_POST['ChucVu'] ?? ''; 

    // Lấy chức vụ hiện tại nếu ChucVu rỗng
    if (empty($ChucVu)) {
        $sqlChucVuCu = $conn->prepare("SELECT ChucVu FROM nhanvien WHERE MaNV = ?");
        $sqlChucVuCu->bind_param("s", $MaNV);
        $sqlChucVuCu->execute();
        $result = $sqlChucVuCu->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $ChucVu = $row['ChucVu'];
        }
    }

    // Xử lý tải lên tệp tin
    if (isset($_FILES['hinh_hanh']) && $_FILES['hinh_hanh']['error'] === UPLOAD_ERR_OK) {
        $hinh_anh = $_FILES['hinh_hanh']['name'];
        $temp_name = $_FILES['hinh_hanh']['tmp_name'];
        $target_dir = "img/";
        $target_file = $target_dir.basename($hinh_anh);
        $hinh_anh=$target_file;
        if (move_uploaded_file($temp_name, $target_file)) {
            // Tệp tin đã được tải lên thành công
        } else {
            echo "Tải lên tệp tin thất bại.";
            exit();
        }
    } else {
        // Lấy hình ảnh hiện tại nếu không có hình ảnh mới được tải lên
        $sqlAnhCu = $conn->prepare("SELECT hinh_anh FROM nhanvien WHERE MaNV = ?");
        $sqlAnhCu->bind_param("s", $MaNV);
        $sqlAnhCu->execute();
        $result = $sqlAnhCu->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hinh_anh = $row['hinh_anh'];
        }
    }

    // Cập nhật thông tin nhân viên
    $sql = $conn->prepare("UPDATE nhanvien SET TenNV=?, ChucVu=?, Email=?, SDT=?, DiaChi=?, hinh_anh=? WHERE MaNV=?");
    $sql->bind_param("sssssss", $TenNV, $ChucVu, $Email, $SDT, $DiaChi, $hinh_anh, $MaNV);

    if ($sql->execute() === TRUE) {
        header("Location: trangquanly.php"); // Chuyển hướng trở lại trang chính sau khi cập nhật
        exit();
    } else {
        echo "Lỗi: " . $sql->error;
    }
} else {
    echo "Dữ liệu không hợp lệ.";
}

$conn->close();
?>