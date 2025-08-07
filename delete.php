<?php
require_once('connect.php');
$c = new Connect();
$dblink = $c->connectToPDO();
if (isset($_POST['delete'])) {
    $maqldonhang = $_POST['Maqldonhang'];
    $sql = "DELETE FROM `quanlydonhang` WHERE `Maqldonhang` = '$maqldonhang'";
    $stmt = $dblink->prepare($sql);
    if (($stmt->execute() == TRUE) && ($stmt->rowCount() == 1)) {
        echo "<script>
            alert ('Đơn hàng đã được xoá thành công'); 
            window.location.href = 'oder_management.php';
        </script>";
    } else {
        echo "Lỗi không thể xoá đơn hàng " ;
    }
}
?>
