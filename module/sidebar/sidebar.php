<div class="sidebar">
    <ul class="list_sidebar">
        <?php
        try {
            // Truy vấn danh mục
            $sql_danhmuc = "SELECT * FROM tbl_categories";
            $stmt = $pdo->prepare($sql_danhmuc);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Hiển thị danh mục
            foreach ($categories as $row_danhmuc) { ?>
                <li class="list_sidebar">
                    <a href="index.php?quanly=danhmucsanpham&idDanhmuc=<?php echo $row_danhmuc['id_category']; ?>">
                        <?php echo htmlspecialchars($row_danhmuc['name'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
        <?php }
        } catch (PDOException $e) {
            echo "Lỗi";
        }
        ?>
    </ul>
</div>