<?php
// Truy vấn danh sách danh mục
$sql_loadDanhmuc = "SELECT * FROM tbl_categories";
$stmt = $pdo->prepare($sql_loadDanhmuc);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="list_category">
    <table border="1 solid #f0f0f0" style="border-style: dashed;">
        <th colspan="2">Danh mục</th>
        <?php
        if (!empty($categories)) {
            foreach ($categories as $row) {
        ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <a href="modules/quanlydanhmuc/controll.php?idDanhmuc=<?php echo $row['id_category']; ?>">Xóa</a>
                        | 
                        <a href="?action=quanlydanhmuc&query=sua&idDanhmuc=<?php echo $row['id_category']; ?>">Sửa</a>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='2'>Không có danh mục nào!</td></tr>";
        }
        ?>
    </table>
</div>
