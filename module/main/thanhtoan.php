<?php
session_start();
$totalPrice = 0;

// PDO connection setup
include("./admin/config/config.php");

// Create PDO connection
try {
   // $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Kiểm tra giỏ hàng
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    foreach ($cart as $item) {
        $totalPrice += $item['giasp'] * $item['soluong'];
    }
} else {
    $cart = [];
}

// Kiểm tra nếu form thanh toán được gửi
if (isset($_POST['checkout'])) {
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);
    $notes = htmlspecialchars($_POST['order-notes']);

    // Kiểm tra sự tồn tại của payment_method
    $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'coda'; // Gán giá trị mặc định là 'cod'

    try {
        // Lưu đơn hàng
        $sql_order = "INSERT INTO tbl_order (customer_name, customer_address, customer_phone, notes, total_price, created_at)
                      VALUES (:name, :address, :phone, :notes, :totalPrice, NOW())";
        $stmt_order = $pdo->prepare($sql_order);
        $stmt_order->execute([
            ':name' => $name,
            ':address' => $address,
            ':phone' => $phone,
            ':notes' => $notes,
            ':totalPrice' => $totalPrice
        ]);
        $orderId = $pdo->lastInsertId(); // Get the last inserted order ID

        // Lưu vào payment
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Nếu có đăng nhập, lấy id_user, nếu không thì bằng 0
        $sql_payment = "INSERT INTO tbl_payments (id_order, payment_method, id_user, amount, date_payment)
                        VALUES (:orderId, :paymentMethod, :userId, :totalPrice, NOW())";
        $stmt_payment = $pdo->prepare($sql_payment);
        $stmt_payment->execute([
            ':orderId' => $orderId,
            ':paymentMethod' => $paymentMethod,
            ':userId' => $userId,
            ':totalPrice' => $totalPrice
        ]);

        // Lưu chi tiết sản phẩm
        foreach ($cart as $item) {
            $productId = $item['id'];
            $productName = $item['tensp'];
            $quantity = $item['soluong'];
            $price = $item['giasp'];
            $total = $quantity * $price;

            $sql_order_details = "INSERT INTO tbl_order_details (order_id, product_id, product_name, quantity, price, total)
                                  VALUES (:orderId, :productId, :productName, :quantity, :price, :total)";
            $stmt_order_details = $pdo->prepare($sql_order_details);
            $stmt_order_details->execute([
                ':orderId' => $orderId,
                ':productId' => $productId,
                ':productName' => $productName,
                ':quantity' => $quantity,
                ':price' => $price,
                ':total' => $total
            ]);
        }

        // Xóa giỏ hàng
        unset($_SESSION['cart']);
        $_SESSION['success_message'] = "Thanh toán thành công! Đơn hàng của bạn đã được ghi nhận.";
        header("Location: index.php?quanly=giohang");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    // Nếu không có form thanh toán, gán giá trị mặc định cho paymentMethod
    $paymentMethod = 'cod';
}
?>

<div class="container">
    <h2>THANH TOÁN</h2>
    <form action="index.php?quanly=thanhtoan" method="POST">
        <div class="billing-info">
            <h3>Thông tin thanh toán</h3>
            <label for="name">Họ và tên</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Địa chỉ</label>
            <input type="text" id="address" name="address" required>

            <label for="phone">Số điện thoại</label>
            <input type="text" id="phone" name="phone" required>

            <label for="order-notes">Ghi chú đơn hàng</label>
            <textarea id="order-notes" name="order-notes" rows="3"></textarea>
        </div>

        <div class="order-summary">
            <h3>Thông tin đơn hàng</h3>
            <p>Phương Thức Thanh Toán:
                <?php
                if ($paymentMethod == "cod") {
                    echo "Thanh Toán Tiền Mặt";
                } elseif ($paymentMethod == "momo") {
                    echo "Ví MoMo";
                }
                ?></p>
            <p>Tổng tiền: <?php echo number_format($totalPrice, 0, ',', '.'); ?> đ</p>

            <button type="submit" name="checkout" class="checkout-button">Xác nhận thanh toán</button>
        </div>
    </form>
</div>