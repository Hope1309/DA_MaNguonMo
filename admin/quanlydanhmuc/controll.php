<?php
include("../../config/config.php");

if (isset($_POST['btnAdd'])) {
    $tenDanhmuc = trim($_POST['tenDanhmuc']); // Trim to avoid unnecessary spaces

    if (!empty($tenDanhmuc)) {
        try {
            // Check for duplicate names
            $sql_check = "SELECT COUNT(*) FROM tbl_categories WHERE name = :name";
            $stmt = $pdo->prepare($sql_check);
            $stmt->bindParam(':name', $tenDanhmuc, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                echo "<script>alert('Tên danh mục đã tồn tại! Vui lòng nhập tên khác.');</script>";
                echo "<script>history.back();</script>";
                exit();
            }

            // Proceed to add the category
            $sql_add = "INSERT INTO tbl_categories (name) VALUES (:name)";
            $stmt = $pdo->prepare($sql_add);
            $stmt->bindParam(':name', $tenDanhmuc, PDO::PARAM_STR);
            if ($stmt->execute()) {
                header('Location:../../index.php?action=quanlydanhmuc&query=them');
                exit();
            } else {
                echo "Lỗi: Không thể thêm vào cơ sở dữ liệu!";
            }
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    } else {
        echo "Vui lòng nhập tên danh mục!";
    }
} elseif (isset($_POST['btnEdit'])) {
    $tenDanhmuc = trim($_POST['suaDanhmuc']); // Trim to avoid unnecessary spaces
    $idDanhmuc = $_GET['idDanhmuc'];

    if (!empty($tenDanhmuc)) {
        try {
            // Check for duplicate names excluding the current category
            $sql_check = "SELECT COUNT(*) FROM tbl_categories WHERE name = :name AND id_category != :id";
            $stmt = $pdo->prepare($sql_check);
            $stmt->bindParam(':name', $tenDanhmuc, PDO::PARAM_STR);
            $stmt->bindParam(':id', $idDanhmuc, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                echo "<script>alert('Tên danh mục đã tồn tại! Vui lòng nhập tên khác.');</script>";
                echo "<script>history.back();</script>";
                exit();
            }

            // Proceed to update the category
            $sql_update = "UPDATE tbl_categories SET name = :name WHERE id_category = :id";
            $stmt = $pdo->prepare($sql_update);
            $stmt->bindParam(':name', $tenDanhmuc, PDO::PARAM_STR);
            $stmt->bindParam(':id', $idDanhmuc, PDO::PARAM_INT);
            if ($stmt->execute()) {
                header('Location:../../index.php?action=quanlydanhmuc&query=them');
                exit();
            } else {
                echo "Lỗi: Không thể cập nhật cơ sở dữ liệu!";
            }
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    } else {
        echo "Vui lòng nhập tên danh mục!";
    }
} else {
    $id = $_GET['idDanhmuc'];
    try {
        $sql_delete = "DELETE FROM tbl_categories WHERE id_category = :id";
        $stmt = $pdo->prepare($sql_delete);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header('Location:../../index.php?action=quanlydanhmuc&query=them');
            exit();
        } else {
            echo "Lỗi: Không thể xóa danh mục!";
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>
