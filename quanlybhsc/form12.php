<div class="container">
    <h1>Đặt lịch sửa chữa</h1>

    <form id="form12">
        <div class="form-group">
            <label for="address">Mời chọn sản phẩm bảo hành</label>
            <table>
                <?php 
                include 'config.php';
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $SDT = $_POST["SDT"];
                    $sql = "SELECT * FROM suachua_baohanh WHERE MaKH = ?"; // Câu truy vấn tìm theo MaKH
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $MaKH);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close(); 

            if ($result->num_rows > 0) {
            
                while ($row = $result->fetch_assoc()) {

                ?>
                <tr>
                    <td>
                        <img src="<?php echo $row["Hinhanh"] ?>">
                    </td>
                    <td>
                        <?php echo $row["TenSP"] ?>
                    </td>
                    <td>
                        <input type="checkbox" id="myCheckbox" name="myCheckbox" value="<?php echo $row["MaSCBH"] ; ?>">
                    </td>
                </tr>
                <?php  
                }
            }
        }
                ?>
            </table>
        </div>

        <div class="bt">
            <button id="confirmBtn" class="xn" type="button">Xác nhận</button>
            <button class="huy" type="button">Hủy</button>
        </div>
    </form>
</div>
<script>
document.getElementById('confirmBtn').addEventListener('click', function() {
    // Lấy tất cả checkbox được chọn
    const checkboxes = document.querySelectorAll('input[name="myCheckbox"]:checked');
    let maBHValues = [];
    checkboxes.forEach(checkbox => {
        maBHValues.push(checkbox.value);
    });

    // Chuyển mảng giá trị thành chuỗi phân tách bằng dấu phẩy
    const MaBH = maBHValues.join(',');

    window.location.href = 'form3.php?MaBH=' + encodeURIComponent(MaBH);
});
document.getElementById('HuyBtn').addEventListener('click', function() {
    const maBHValue = document.querySelector('#form2 .form-group:first-child div').textContent;
    window.location.href = 'trangchu.php';
});
</script>
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