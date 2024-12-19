<?php
include("../../config/config.php");
$tenDanhmuc = $_POST['tenDanhmuc'];

if (isset($_POST['btnAdd'])) {
    $sql_add = "INSERT INTO tbl_categories(name) VALUE('" . $tenDanhmuc . "')";
}
mysqli_query($mysqli, $sql_add);
header('Location:../../index.php?action=quanlydanhmuc');
