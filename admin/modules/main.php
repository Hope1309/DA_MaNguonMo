<div class="main_content">
    <?php
    if (isset($_GET['action']) && $_GET['query']) {
        $t = $_GET['action'];
        $query = $_GET['query'];
    } else {
        $t = '';
    }
    if ($t == 'quanlydanhmuc' && $query == 'them') {
        include("modules/quanlydanhmuc/add.php");
        include("modules/quanlydanhmuc/loaddata.php");
    } elseif ($t == 'quanlydanhmuc' && $query == 'sua') {
        include("modules/quanlydanhmuc/edit.php");
    } elseif ($t == 'quanlysanpham' && $query == 'load') {
        include("modules/quanlysanpham/loaddata.php");
    } elseif ($t == 'quanlydonhang' && $query == 'them') {
        include("modules/quanlydonhang/loaddata.php");
        include("modules/quanlydonhang/data.php");
    } else {
        include("modules/dashboard.php");
    }




    ?>
</div>