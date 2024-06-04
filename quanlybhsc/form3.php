<?php 
session_start();
include 'config.php';


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['username'];
    $maBHString = urldecode($_GET['MaBH']);
    $sql = "SELECT * FROM khachhang WHERE MAKH=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$username );
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
<div class="container">
    <h1>Đặt lịch sửa chữa</h1>

    <form id="form3" action="datlich2..php" enctype="multipart/form-data" method="post">
        <div class="form-group">
            <label for="warranty-code">Mã bảo hành</label>
            <input type="text" id="warranty-code" name="warranty-code" value=" <?php echo $maBHString ?>">
        </div>
        <div class="form-group">
            <label for="address">Dia chi</label>
            <input type="text" id="address" name="address" value="<?php echo $row["DiaChi"]; ?>">
        </div>
        <div class="form-group">
            <label for="date">Thời gian</label>
            <input type="date" id="date" name="date">
        </div>
        <div class="product-image">
            <img src="" alt="Hình ảnh sản phẩm" id="productImage">
            <input type="file" id="imageUpload" name="imageUpload" accept="image/*" style="display: none;">
            <button type="button" onclick="document.getElementById('imageUpload').click();">+ Tải ảnh lên</button>
        </div>
        <div class="form-group">
            <label for="status">6. Tình trạng</label>
            <input type="text" id="status" name="status">
        </div>
        <div class="form-group">
            <label for="description">8. Mô tả</label>
            <textarea id="description" name="description" rows="4"></textarea>
        </div>
        <button class="xn" type="submit">Đặt</button>
    </form>
</div>
<script>
const imageUpload = document.getElementById('imageUpload');
const productImage = document.getElementById('productImage');

imageUpload.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();

        reader.addEventListener('load', function() {
            productImage.src = reader.result;
        });

        reader.readAsDataURL(file);
    }
});
</script>

<?php
    
} else {
    echo "MaBH parameter missing";
}


?>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    margin: 0;
    padding: 0;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
}

.header img {
    height: 60px;
    /* Tăng kích thước của logo */
}

.search-bar {
    flex-grow: 1;
    margin: 0 20px;
}

.search-bar input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.menu {
    display: flex;
    gap: 20px;
}

.menu a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
}

.menu a:hover {
    text-decoration: underline;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="tel"],
input[type="date"],
select,
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.product-image {
    text-align: center;
    margin-bottom: 15px;
}

.product-image img {
    width: 200px;
    height: auto;
    display: block;
    margin: 0 auto 10px;
}

.product-image button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.product-image button:hover {
    background-color: #45a049;
}

button[type="submit"] {
    width: 100%;
    padding: 10px;

    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;

}

button[type="button"] {
    width: 100%;
    padding: 10px;

    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;

}

footer {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
    color: #666;
}

.footer-links {
    margin: 10px 0;
}

.footer-links a {
    margin: 0 10px;
    color: #333;
    text-decoration: none;
}

.footer-links a:hover {
    text-decoration: underline;
}

.da-thong-bao {
    width: 50px;
    /* Thu nhỏ ảnh "Đã thông báo" */
    vertical-align: middle;
}

.bt {
    display: flex;
}

.huy {
    margin: 20px;
    background-color: rgb(216, 76, 76);
}

.xn {
    background-color: #4CAF50;
    margin: 20px;
}

/* #form2 {
    display: none;
}
#form3 {
    display: none;
}
#form1 {
    display: block;
}
#form12 {
    display: none;
} */
.kt {
    background-color: #4CAF50;
}

img {

    width: 60px;
    height: 60px;
}

table td {
    padding: 10px;
}
</style>