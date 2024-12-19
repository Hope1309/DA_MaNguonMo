<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
// if (isset($_GET['idxoasp'])) {
//     $id = $_GET['idxoasp'];

//     // Giảm số lượng sản phẩm mà không kiểm tra nếu số lượng giảm xuống 0
//     foreach ($_SESSION['cart'] as $key => $item) {
//         if ($item['id'] == $id) {
//             $item['soluong']--; // Giảm số lượng xuống 1
//             $_SESSION['cart'][$key] = $item; // Cập nhật giỏ hàng
//         }
//     }

//     $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index lại mảng giỏ hàng

//     header("Location: ../../index.php?quanly=giohang");
//     exit();
// }

// $cart = $_SESSION['cart'];

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['idxoasp'])) {
    $id = $_GET['idxoasp'];

    // Loại bỏ sản phẩm khỏi giỏ hàng
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['cart'][$key]);
        }
    }

    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: ../../index.php?quanly=giohang");
    exit();
}

$cart = $_SESSION['cart'];
// Tính tổng tiền
$totalPrice = 0;
foreach ($cart as $item) {
    $totalPrice += $item['giasp'] * $item['soluong'];
}
?>

<div class="container">
    <h2>GIỎ HÀNG CỦA BẠN</h2>
    <div class="cart-info">
        <?php if (empty($cart)): ?>
            <div class="empty-cart-message">
                <p>Giỏ hàng của bạn đang trống. Hãy tiếp tục mua sắm!</p>
                <a href="index.php" class="continue-shopping">TIẾP TỤC MUA HÀNG</a>
            </div>
        <?php else: ?>
            <div class="cart-details">
                <p>Bạn đang có <span id="product-count"><?php echo count($cart); ?></span> sản phẩm trong giỏ hàng</p>

                <?php foreach ($cart as $item): ?>
                    <div class="product-item" data-id="<?php echo $item['id']; ?>">
                        <img src="/image/<?php echo htmlspecialchars($item['hinhanh']); ?>" alt="<?php echo htmlspecialchars($item['tensp']); ?>">
                        <div class="product-item-info">
                            <p><?php echo htmlspecialchars($item['tensp']); ?></p>
                            <div class="product-quantity">
                                <button class="quantity-decrease" data-id="<?php echo $item['id']; ?>">-</button>
                                <input type="text" class="quantity-input" value="<?php echo $item['soluong']; ?>" data-id="<?php echo $item['id']; ?>">
                                <button class="quantity-increase" data-id="<?php echo $item['id']; ?>">+</button>
                            </div>
                            <p class="total-price"><?php echo number_format($item['giasp'] * $item['soluong'], 0, ',', '.'); ?> đ</p>
                        </div>
                        <a href="/module/main/capnhatgiohang.php?idxoasp=<?php echo $item['id']; ?>" class="btn-xoa">XÓA</a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="order-summary">
                <h3>Thông tin đơn hàng</h3>
                <p>Phương Thức Thanh Toán</p>
                <select id="payment-method" name="payment_method">
                    <option value="cod">Thanh toán khi nhận hàng</option>
                    <option value="momo">Ví MoMo</option>
                </select>
                <p class="total-price-value">Tổng tiền: <span id="total-price"><?php echo number_format($totalPrice, 0, ',', '.'); ?> đ</span></p>
                <a href="index.php?quanly=thanhtoan" class="checkout">THANH TOÁN</a>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($cart)): ?>
        <a href="index.php" class="continue-shopping">TIẾP TỤC MUA HÀNG</a>
    <?php endif; ?>
</div>

<script src="/javascript/main.js"></script>

<?php
if (isset($_SESSION['success_message'])) {
    echo "<div class='success-message'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']);
}
?>

