<?php
$id = isset($_GET['idDanhmuc']) ? (int)$_GET['idDanhmuc'] : 0;

try {
    // Truy vấn sản phẩm theo danh mục
    if ($id > 0) {
        $sql_product = "SELECT * FROM tbl_products, tbl_categories 
                        WHERE tbl_products.id_category = tbl_categories.id_category 
                        AND tbl_categories.id_category = :idDanhmuc";
        $stmt_product = $pdo->prepare($sql_product);
        $stmt_product->bindParam(':idDanhmuc', $id, PDO::PARAM_INT);
        $stmt_product->execute();
        $products_by_category = $stmt_product->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Truy vấn tất cả sản phẩm
        $sql = "SELECT * FROM tbl_products";
        $stmt_all = $pdo->prepare($sql);
        $stmt_all->execute();
        $all_products = $stmt_all->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Lỗi";
}
?>

<h3>SẢN PHẨM</h3>

<!-- Hiển thị tất cả sản phẩm -->
<?php if ($id == 0) { ?>
    <div class="product_list">
        <?php foreach ($all_products as $row) { ?>
            <div class="product_item">
                <a href="index.php?quanly=sanpham&id=<?php echo $row['id_product']; ?>">
                    <div class="product_image">
                        <img src="./image/<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image">
                    </div>
                    <div class="product_info">
                        <p class="title_product"><?php echo htmlspecialchars($row['namepro'], ENT_QUOTES, 'UTF-8'); ?></p>
   
                        <p class="price_product"><?php 
                            if ($row['price'] == 0) {
                                    echo ""; 
                                } else {
                                    echo number_format($row['price'], 0, ',', '.') . "₫";
                                }
                                ?></p>
                    </div>
                    <!-- <div class="box_buy">
                        <button class="buy-now">Mua Ngay</button>
                        <a href="#" class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div> -->
                    <div class="box_buy">
                        <?php if ($row['price'] > 0) { ?>
                            <button class="buy-now">Mua Ngay</button>
                        <?php } else { ?>
                            <button class="buy-now" disabled>Liên hệ</button>
                        <?php } ?>
                        </a>
                    </div>
                        
                </a>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <!-- Hiển thị sản phẩm theo danh mục -->
    <div class="product_list">
        <?php foreach ($products_by_category as $row_product) { ?>
            <div class="product_item">
                <a href="index.php?quanly=sanpham&id=<?php echo $row_product['id_product']; ?>">
                    <div class="product_image">
                        <img src="./image/<?php echo htmlspecialchars($row_product['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image">
                    </div>
                    <div class="product_info">
                        <p class="title_product"><?php echo htmlspecialchars($row_product['namepro'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="price_product"><?php echo number_format($row_product['price'], 0, ',', '.'); ?>₫</p>
                    </div>
                    <div class="box_buy">
                        <button class="buy-now">Mua Ngay</button>
                        <a href="#" class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
<?php } ?>