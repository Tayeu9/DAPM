<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Them moi</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/nen.css">
</head>


<body>
    <div>
        <h2 style="color:white;">Thêm mới nhân viên</h2>

        <div>
            <form class="form" action="process_add.php" enctype="multipart/form-data" method="post">
                <div class="bentrai">
                    <div class="_form_group2">
                        <label for="hinh">Hình ảnh:</label>
                        <img src="" id="hinh" alt="Hình ảnh nhân viên">
                        <input type="file" id="hinh_hanh" name="hinh_hanh" accept="image/*" style="display: none;">
                        <button type="button" onclick="document.getElementById('hinh_hanh').click();">+ Tải ảnh
                            lên</button>
                    </div>
                </div>
                <div class="benphai">
                    <div class="_form_group">
                        <label for="MaNV">Ma NV:</label>
                        <?php 
    include 'config.php'; 
    $sql = "SELECT MAX(MaNV) AS MaxMaNV FROM nhanvien";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $maxMaNV = $row["MaxMaNV"];
    
   
    $number = intval(substr($maxMaNV, 2)) + 1;
    
  
    $newMaNV = "NV" . str_pad($number, 4, '0', STR_PAD_LEFT);
    echo "<input type=\"text\" id=\"MaNV\" name=\"MaNV\" value=\"$newMaNV\">";
}
$conn->close();
    ?>
                    </div>
                    <div class="_form_group">
                        <label for="TenNV">Tên NV:</label>
                        <input type="text" id="TenNV" name="TenNV">
                    </div>
                    <div class="_form_group">
                        <label for="ChucVu">Chức vụ:</label>
                        <select id="ChucVu" name="ChucVu">
                            <option value="">--Chọn chức vụ--</option>
                            <option value="Quản Lý">Quản lý</option>
                            <option value="CSKH">NV CSKH</option>
                            <option value="NV Sửa Chữa">NV Sửa chữa</option>
                        </select>
                    </div>
                    <div class="_form_group">
                        <label for="Email">Email:</label>
                        <input type="text" id="Email" name="Email">
                    </div>
                    <div class="_form_group">
                        <label for="SDT">Số điện thoại:</label>
                        <input type="text" id="SDT" name="SDT">
                    </div>
                    <div class="_form_group">
                        <label for="DiaChi">Địa chỉ:</label>
                        <input type="text" id="DiaChi" name="DiaChi">
                    </div>
                    <div class="_form_actions">
                        <button type="submit">Thêm mới</button>
                        <button type="button" onclick="window.location.href='trangquanly.php'">Hủy</button>
                    </div>
                </div>


            </form>
        </div>
    </div>
    <script>
    const imageUpload = document.getElementById('hinh_hanh');
    const productImage = document.getElementById('hinh');
    const defaultImage = 'path/to/default/image.jpg';

    // Đặt ảnh mặc định ban đầu
    productImage.src = defaultImage;

    imageUpload.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.addEventListener('load', function() {
                // Kiểm tra xem ảnh hiện tại có phải là ảnh mặc định không
                if (productImage.src !== defaultImage) {
                    // Nếu không phải ảnh mặc định, thực hiện thay đổi
                    productImage.src = reader.result;
                }
            });

            reader.readAsDataURL(file);
        } else {
            productImage.src = defaultImage;
        }
    });
    </script>
</body>


</html>