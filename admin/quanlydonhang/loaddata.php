<?php 
$mysqli = new mysqli("localhost","root","","db_webmohinh");
// Truy vấn cơ sở dữ liệu
$sql = "SELECT * FROM tbl_order";
$query = mysqli_query($mysqli, $sql);

// Xử lý xóa đơn hàng
// if (isset($_GET['delete_id'])) {
//     $deleteId = $_GET['delete_id'];

//     // // Xóa các chi tiết đơn hàng liên quan trước
//     // $sql_delete_details = "DELETE FROM tbl_order_details WHERE order_id = '$deleteId'";
//     // mysqli_query($mysqli, $sql_delete_details);

//     // // Xóa đơn hàng
//     // $sql_delete_order = "DELETE FROM tbl_order WHERE id = '$deleteId'";
//     // mysqli_query($mysqli, $sql_delete_order);

//     // Chuyển hướng về trang quản lý đơn hàng
//     header("Location:admin/index.php?action=quanlydonhang&query=them");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="vi">
<head>          
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php if ($query && mysqli_num_rows($query) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên khách hàng</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Ghi chú</th>
                <th>Tổng tiền (VNĐ)</th>
                <th>Ngày tạo</th>
                <th>Chi Tiết</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $query->fetch_assoc()){ ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($row['customer_address']); ?></td>
                <td><?php echo htmlspecialchars($row['customer_phone']); ?></td>
                <td><?php echo htmlspecialchars($row['notes']); ?></td>
                <td><?php echo number_format($row['total_price'], 0, ',', '.'); ?> đ</td>
                <td><?php echo $row['created_at']; ?></td>
                <td><a href="/admin/modules/quanlydonhang/data.php?id=<?php echo $row['id']; ?>">Xem chi tiết</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Không có đơn hàng nào.</p>
    <?php endif; ?>
</body>
</html>
