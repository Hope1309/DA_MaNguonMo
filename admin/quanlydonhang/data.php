<?php
$mysqli = new mysqli("localhost","root","","db_webmohinh");

// Kiểm tra xem có truyền ID đơn hàng không
if (isset($_GET['id'])) {
    $orderId = $_GET['id'];

    // Truy vấn đơn hàng
    $sql_order = "SELECT * FROM tbl_order WHERE id = '$orderId'";
    $query_order = mysqli_query($mysqli, $sql_order);
    $order = mysqli_fetch_assoc($query_order);

    // Truy vấn chi tiết đơn hàng
    $sql_order_details = "SELECT * FROM tbl_order_details WHERE order_id = '$orderId'";
    $query_order_details = mysqli_query($mysqli, $sql_order_details);
} else {
    // echo "Không có đơn hàng này!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #2a9d8f;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

    <h2>Chi tiết đơn hàng #<?php echo $order['id']; ?></h2>

    <h3>Thông tin đơn hàng</h3>
    <p>Tên khách hàng: <?php echo htmlspecialchars($order['customer_name']); ?></p>
    <p>Địa chỉ: <?php echo htmlspecialchars($order['customer_address']); ?></p>
    <p>Số điện thoại: <?php echo htmlspecialchars($order['customer_phone']); ?></p>
    <p>Ghi chú: <?php echo htmlspecialchars($order['notes']); ?></p>
    <p>Tổng tiền: <?php echo number_format($order['total_price'], 0, ',', '.'); ?> đ</p>
    <p>Ngày tạo: <?php echo $order['created_at']; ?></p>

    <h3>Chi tiết sản phẩm</h3>
    <table>
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($detail = mysqli_fetch_assoc($query_order_details)): ?>
            <tr>
                <td><?php echo htmlspecialchars($detail['product_name']); ?></td>
                <td><?php echo $detail['quantity']; ?> </td>
                <td><?php echo number_format($detail['price'], 0, ',', '.'); ?> đ</td>
                <td><?php echo number_format($detail['total'], 0, ',', '.'); ?> đ</td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="/admin/index.php?action=quanlydonhang&query=them">Quay lại</a>

</body>
</html>
