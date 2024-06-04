<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $SDT = $_POST["SDT"];
    $MaBH = $_POST["MaBH"];
    $isSDTValid = preg_match("/^\d{10,11}$/", $SDT);
    
   
    if(!empty($MaBH))
    {
        $sql = "SELECT * FROM suachua_baohanh WHERE MaSCBH= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $MaBH);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $NgayHetHanBH = $row['NgayHetHanBH'];
            $ngayHienTai = date('Y-m-d');
            if ($NgayHetHanBH < $ngayHienTai) {
                echo "<script>document.getElementById('form1').style.display = 'none';</script>";
                include 'form2.php';
            } else {
                echo "<script>document.getElementById('form1').style.display = 'none';</script>";
                include 'form3.php';
            }

        }
        else {
          
           echo "sai r";
        }
    }
    else {
          
        if(!empty($SDT)) {
            $sqlMaKH = "SELECT MaKH FROM khachhang WHERE SDT = ?"; // Câu truy vấn tìm MaKH
            $stmtMaKH = $conn->prepare($sqlMaKH);
            $stmtMaKH->bind_param("s", $SDT);
            $stmtMaKH->execute();
            $resultMaKH = $stmtMaKH->get_result();
            $stmtMaKH->close();

        if ($resultMaKH->num_rows > 0) {
            $rowMaKH = $resultMaKH->fetch_assoc();
            $MaKH = $rowMaKH['MaKH'];
            
            $sql = "SELECT * FROM suachua_baohanh WHERE MaKH = ?"; // Câu truy vấn tìm theo MaKH
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $MaKH);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close(); 
            
                $row = $result->fetch_assoc();
                $NgayHetHanBH = $row['NgayHetHanBH'];
                $ngayHienTai = date('Y-m-d');
                $_SESSION['MaKH2'] = $MaKH;
               
                if ($NgayHetHanBH < $ngayHienTai) {

                    echo "<script>document.getElementById('form1').style.display = 'none';</script>";
                    include 'form2.php';
                } else {
                    
                    echo "<script>document.getElementById('form1').style.display = 'none';</script>";
                    include 'form12.php';
                }
    
            }
            else {
              
               echo "sai r";
            }
        }
        else {
            echo "k có sdt";
        }
    }
    }  
?>