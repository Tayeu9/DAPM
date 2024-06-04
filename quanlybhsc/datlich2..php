<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $warrantyCode = $_POST["warranty-code"];
    $address = $_POST["address"];
    $date = $_POST["date"];
    $status = $_POST["status"];
    $description = $_POST["description"];

    
    $hinh_hanh = $_FILES['imageUpload']['name'];
    $temp_name = $_FILES['imageUpload']['tmp_name'];
    $target_dir = "img/"; 
    $target_file = $target_dir.basename($hinh_hanh);
    $allowUpload   = true;
    
    move_uploaded_file($temp_name, $target_file);
            
    $conn->begin_transaction();
    try {
       echo  $warrantyCode;
        $insertSql = "INSERT INTO chitiet_scbh (MaSCBH, NgayBH, HinhAnh, TinhTrangTruocBH, Ghichu) 
                          VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("sssss", $warrantyCode, $date, $target_file, $status, $description);

            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi thêm " . $stmt->error);
            }
        $conn->commit();
        header('Location: trangchu.php'); 
        exit;
    }
    catch (Exception $e) {
        // Hoàn tác giao dịch nếu có lỗi
        $conn->rollback();
        echo "Đã xảy ra lỗi: " . $e->getMessage();
    }
    $conn->close();
 
   
}
?>