<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Thêm Sản Phẩm</title>
</head> 
<body>
    <?php 
    $mysqli = new mysqli("localhost", "root", "", "db_webmohinh");
    $sql_categories = "SELECT * FROM tbl_categories";
    $query_categories = mysqli_query($mysqli, $sql_categories);
    if(isset($_POST['sbm']))
    {
        $name = $_POST['namepro'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        $id_category = $_POST['id_category'];
        
        $sql = "INSERT INTO tbl_products (namepro,description,price,stock,image,id_category)
        VALUES('$name','$description','$price','$stock','$image','$id_category')";
        $query = mysqli_query($mysqli,$sql);
        move_uploaded_file( $image_tmp, 'image/.'.$image);
        header('Location:../../index.php?action=quanlysanpham&query=load');
        
    }
    ?>
  
    <div class="card mt-5 mx-auto" style="width: 50%;">
        <div class="card-header"><h1>Thêm Sản Phẩm</h1></div> 
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="">Tên Sản Phẩm</label>
                    <input type="text" name="namepro" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="">Mô Tả</label>
                    <input type="text" name="description" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="">Giá Tiền</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="">Số Lượng</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="">Hình Ảnh Sản Phẩm</label><br>
                    <input type="file" name="image" class="form-control-file" required>
                </div>
                <div class="form-group mb-3">
                    <label for="">Danh Mục</label>
                    <select class="form-control" name="id_category" required>
                        <?php while ($row_cate = mysqli_fetch_assoc($query_categories)) { ?>
                            <option value="<?php echo $row_cate['id_category']; ?>"><?php echo $row_cate['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button name="sbm" class="btn btn-success" type="submit">THÊM SẢN PHẨM</button>
            </form>
        </div>
    </div>
</body>
</html>