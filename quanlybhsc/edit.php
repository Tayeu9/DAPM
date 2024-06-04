<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa nhân viên</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/nen.css">
</head>

<body>
    <!-- <header>
        <nav>
            <ul class="main-menu">
                <li><a href="#">Trang Chủ</a></li>
                <li><a href="#">Giới Thiệu</a></li>
                <li><a href="#">Dịch Vụ</a></li>
                <li><a href="#">Liên Hệ</a></li>
            </ul>
        </nav>
    </header> -->
    <div>
        <h2 style="color:white">Sửa thông tin nhân viên</h2>
        <?php
        include 'config.php';
    if (isset($_GET['id'])) {
        $maNV = $_GET['id']; 

        $sql = "SELECT * FROM nhanvien WHERE MaNV = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $maNV);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
        <div>
            <form class="form" action="process_edit.php" enctype="multipart/form-data" method="post">
                <div class="bentrai">
                    <div class="_form_group2">
                        <label for="hinh">Hình ảnh:</label>
                        <img src="<?php echo htmlspecialchars($row['hinh_anh']); ?>" id="hinh" alt="Hình ảnh nhân viên">
                        <input type="file" id="hinh_hanh" name="hinh_hanh" accept="image/*" style="display: none;">
                        <button type="button" onclick="document.getElementById('hinh_hanh').click();">+ Tải ảnh
                            lên</button>
                    </div>
                </div>
                <div class="benphai">
                    <div class="_form_group">
                        <label for="MaNV">Ma NV:</label>
                        <input type="text" id="MaNV" name="MaNV" value="<?php echo $row['MaNV']; ?>">
                    </div>
                    <div class="_form_group">
                        <label for="TenNV">Tên NV:</label>
                        <input type="text" id="TenNV" name="TenNV" value="<?php echo $row['TenNV']; ?>">
                    </div>
                    <div class="_form_group">
                        <label for="ChucVu">Chức vụ:</label>
                        <select id="ChucVu" name="ChucVu">
                            <option value=""><?php echo $row['ChucVu']; ?></option>
                            <option value="Quản Lý">Quản lý</option>
                            <option value="CSKH">NV CSKH</option>
                            <option value="NV Sửa Chữa">NV Sửa chữa</option>
                        </select>

                    </div>
                    <div class="_form_group">
                        <label for="Email">Email:</label>
                        <input type="text" id="Email" name="Email" value="<?php echo $row['Email']; ?>">
                    </div>
                    <div class="_form_group">
                        <label for="SDT">Số điện thoại:</label>
                        <input type="text" id="SDT" name="SDT" value="<?php echo $row['SDT']; ?>">
                    </div>
                    <div class="_form_group">
                        <label for="DiaChi">Địa chỉ:</label>
                        <input type="text" id="DiaChi" name="DiaChi" value="<?php echo $row['DiaChi']; ?>">
                    </div>
                    <div class="_form_actions">
                        <button type="submit">Cập nhật</button>
                        <button type="button" onclick="window.location.href='index.php'">Hủy</button>
                    </div>
                </div>


            </form>
        </div>
    </div>
    <script>
    const inputHinhAnh = document.getElementById('hinh_hanh');
    const hinhAnh = document.getElementById('hinh');

    inputHinhAnh.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.addEventListener('load', function() {
                hinhAnh.src = reader.result;
            });

            reader.readAsDataURL(file);
        }
    });
    </script>

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