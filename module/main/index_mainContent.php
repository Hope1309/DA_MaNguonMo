<?php
try {
    // Truy vấn lấy tất cả sản phẩm
    $sql = "SELECT * FROM tbl_products";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy danh sách sản phẩm dưới dạng mảng liên kết
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
    exit();
}
?>

<h3>SẢN PHẨM MỚI NHẤT</h3>

<div class="product_list">
    <?php foreach ($products as $row) { ?>
        <a href="index.php?quanly=sanpham&id=<?php echo $row['id_product']; ?>">
            <div class="product_item">
                <div class="product_image">
                    <img src="./image/<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image">
                </div>
                <div class="product_info">
                    <p class="title_product"><?php echo htmlspecialchars($row['namepro'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="product_info">
                    <p class="price_product">
                        <?php 
                        if ($row['price'] == 0) {
                            echo "Liên hệ"; // Hiển thị thông báo khi giá bằng 0
                        } else {
                            echo number_format($row['price'], 0, ',', '.') . "₫";
                        }
                        ?>
                    </p>
                </div>
                <div class="box_buy">
                    <?php if ($row['price'] > 0) { ?>
                        <button class="buy-now">Mua Ngay</button>
                    <?php } else { ?>
                        <button class="buy-now" disabled>Liên hệ</button>
                    <?php } ?>
                    <a href="#" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
            </div>
        </a>
    <?php } ?>
</div>