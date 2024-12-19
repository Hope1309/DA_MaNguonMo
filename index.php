<?php
include("./admin/config/config.php");

if (isset($_GET['idDanhmuc'])) {
    $idDanhmuc = $_GET['idDanhmuc'];

    try {
        $sql = "SELECT * FROM tbl_categories WHERE id_category = :idDanhmuc";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idDanhmuc', $idDanhmuc, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $categoryName = $row['name'];
            $title = $categoryName;
        }
    } catch (PDOException $e) {
        echo "Lỗi lấy tên danh mục";
    }
}
if (isset($_GET['quanly'])) {
    $action = $_GET['quanly'];
} else {
    $action = "";
}

if ($action == "danhmucsanpham") {
    if (!isset($categoryName)) {
        $title = "Sản phẩm";
    } else {
        $title = "Mô hình " . $categoryName;
    }
} elseif ($action == "giohang") {
    $title = "Giỏ Hàng";
} elseif ($action == "lienhe") {
    $title = "Liên Hệ";
} else {
    $title = "Trang Chủ";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="/image/logo1.png">


    <title><?php echo $title ?></title>
</head>

<body>
    <div class="wrapper">

        <?php
        include("./admin/config/config.php");

        include("./module/menu.php");
        include("./module/main.php");
        include("./module/footer.php");
        ?>




    </div>


</body>

</html>