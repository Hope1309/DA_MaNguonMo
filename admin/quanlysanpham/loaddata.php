<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Danh Sách Sản Phẩm</title>
</head>

<body>
    <?php
    $mysqli = new mysqli("localhost", "root", "", "db_webmohinh");
    if ($mysqli->connect_error) {
        die("Kết nối thất bại: " . $mysqli->connect_error);
    }

    $sqlsp = "SELECT tbl_products.*, tbl_categories.name AS category_name 
              FROM tbl_products 
              INNER JOIN tbl_categories ON tbl_products.id_category = tbl_categories.id_category";

    $query = mysqli_query($mysqli, $sqlsp);

    if (!$query) {
        echo "Lỗi truy vấn: " . mysqli_error($mysqli);
        exit;
    }
    ?>
    <div class="form_addCate_item">
        <div class="card">
            <div class="card-header">
                <h2>DANH SÁCH SẢN PHẨM</h2>
            <a class="btn btn-success"  href="./modules/quanlysanpham/add.php">Thêm</a>

            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>TT</th>
                            <th>Tên</th>
                            <th>Mô Tả</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Ảnh</th>
                            <th>Danh Mục</th>
                            <th colspan="2">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row['namepro']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo number_format($row['price'], 0); ?> VND</td>
                                <td><?php echo $row['stock']; ?></td>
                                <td>
                                    <img src=".././image/<?php echo htmlspecialchars($row['image']); ?>" width="100px">
                                </td>
                                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                                <td><a class="btn btn-secondary" href="./modules/quanlysanpham/edit.php?id=<?php echo $row['id_product']; ?>">Sửa</a></td>
                                <td><a class="btn btn-danger" href="./modules/quanlysanpham/remove.php?id=<?php echo $row['id_product']; ?>">Xóa</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>