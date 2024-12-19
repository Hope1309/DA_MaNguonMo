<?php
session_start();

// Include PDO database configuration
include('../../admin/config/config.php');

// PDO database connection
try {
    //$pdo = new PDO("mysql:host=localhost;dbname=db_webmohinh", "root", "");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Thêm sản phẩm vào giỏ hàng
if (isset($_POST['themgiohang'])) {
    $id = $_GET['idsp'];
    $quantity = 1;

    // Fetch product from the database using prepared statement
    $sql = "SELECT * FROM tbl_products WHERE id_product = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $list_product = array(
            array(
                'id' => $id,
                'tensp' => $row['namepro'],
                'soluong' => $quantity,
                'giasp' => $row['price'],
                'hinhanh' => $row['image'],
                'danhmuc' => $row['id_category']
            )
        );

        if (isset($_SESSION['cart'])) {
            $found = false;
            $product = array();

            foreach ($_SESSION['cart'] as $cart_item) {
                if ($cart_item['id'] == $id) {
                    $product[] = array(
                        'id' => $cart_item['id'],
                        'tensp' => $cart_item['tensp'],
                        'soluong' => $cart_item['soluong'] + 1,
                        'giasp' => $cart_item['giasp'],
                        'hinhanh' => $cart_item['hinhanh'],
                        'danhmuc' => $cart_item['danhmuc']
                    );
                    $found = true;
                } else {
                    $product[] = $cart_item;
                }
            }

            if (!$found) {
                $product = array_merge($product, $list_product);
            }

            $_SESSION['cart'] = $product;
        } else {
            $_SESSION['cart'] = $list_product;
        }
    }

    header('Location:../../index.php?quanly=giohang');
    exit();
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['idxoasp'])) {
    $id = $_GET['idxoasp'];

    // Kiểm tra nếu giỏ hàng tồn tại và không rỗng
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $cart_item) {
            if ($cart_item['id'] == $id) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    header("Location: ../../index.php?quanly=giohang");
    exit();
}

// Cập nhật giỏ hàng với JS (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $quantity = intval($_POST['quantity']);

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) {
            $_SESSION['cart'][$key]['soluong'] = $quantity;
            $itemTotalPrice = $item['giasp'] * $quantity;
            break;
        }
    }

    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalPrice += $item['giasp'] * $item['soluong'];
    }

    // Send the updated prices as JSON response
    echo json_encode([
        'success' => true,
        'totalPrice' => $totalPrice,
        'totalPriceFormatted' => number_format($totalPrice, 0, ',', '.') . ' đ',
        'itemTotalPriceFormatted' => number_format($itemTotalPrice, 0, ',', '.') . ' đ',
    ]);
    exit();
}
