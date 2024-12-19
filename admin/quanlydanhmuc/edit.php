<?php
// Lấy thông tin danh mục cần sửa
$sql_edit_Category = "SELECT * FROM tbl_categories WHERE id_category = :idDanhmuc";
$stmt = $pdo->prepare($sql_edit_Category);
$stmt->bindParam(':idDanhmuc', $_GET['idDanhmuc'], PDO::PARAM_INT);
$stmt->execute();
$category = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="form_addCate">
    <table border="1" cellpadding="10" cellspacing="0">
        <form action="modules/quanlydanhmuc/controll.php?idDanhmuc=<?php echo $_GET['idDanhmuc']; ?>" method="POST">
            <?php if ($category) { ?>
                <tr>
                    <th colspan="2">Sửa tên danh mục</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="suaDanhmuc" placeholder="Tên danh mục" value="<?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>">
                    </td>
                    <td>
                        <button type="submit" name="btnEdit">Sửa</button>
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td colspan="2">Không tìm thấy danh mục!</td>
                </tr>
            <?php } ?>
        </form>
    </table>
</div>
