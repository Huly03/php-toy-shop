<?php
include_once("header.php");
include_once("connect.php");

$c = new Connect();
$dblink = $c->connectToPDO();
if(isset($_COOKIE['cc_Username'])){
    $user = $_COOKIE['cc_Username'];
    
    if(isset($_GET['Maxe'])){
        $p_id = $_GET['Maxe'];
        $sqlSelect1 = "SELECT Maxe FROM giohang WHERE Username=? AND Maxe=?";
        $re = $dblink->prepare($sqlSelect1);
        $re->execute(array("$user","$p_id"));

        if($re->rowCount() == 0){
            $query = "INSERT INTO giohang(Username, Maxe, Soluongxe, Ngaylap) VALUE(?,?,1,CURDATE())";
        }else{
            $query = "UPDATE giohang SET Soluongxe = Soluongxe + 1 where Username=? and Maxe=?";
        }
        $stmt = $dblink->prepare($query);
        $stmt->execute(array("$user","$p_id"));

    }else if(isset($_GET['del_Magiohang'])){
        $cart_del = $_GET['del_Magiohang'];
        $query = "DELETE FROM giohang WHERE Magiohang=?";
        $stmt = $dblink->prepare($query);
        $stmt->execute(array($cart_del));
    }
    $sqlSelect = "SELECT * FROM giohang c, xe p WHERE c.Maxe = p.Maxe and c.Username=?";
    $stmt1 = $dblink->prepare($sqlSelect);
    $stmt1->execute(array($user));
    $rows = $stmt1->fetchAll(PDO::FETCH_BOTH);

    $disabled = "";
    foreach($rows as $row){
        // Lấy số lượng xe trong bảng xe
        $sqlSelect2 = "SELECT Soluong FROM xe WHERE Maxe=?";
        $stmt2 = $dblink->prepare($sqlSelect2);
        $stmt2->execute(array($row['Maxe']));
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        // So sánh số lượng xe trong giỏ hàng và bảng xe
        if ($row['Soluongxe'] > $row2['Soluong']) {
            echo "Sản phẩm bạn thêm hiện không đủ số lượng";
            // Nếu số lượng xe trong giỏ hàng lớn hơn, vô hiệu hóa nút thanh toán và thoát khỏi vòng lặp
            $disabled = "disabled";
            break;
        }
    }

}else{
    header("Location: login.php");
}
?>
<div class="container">
    <h1 class="fw-bold mb-0 text-black">Giỏ hàng</h1>
    <!-- <h6 class="mb-0 text-muted"><?=$stmt1->rowCount()?></h6> -->
    <table class="table">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Sản phẩm xe</th>
            <th>Tổng tiền</th>
            <th>Thao tác</th>

        </tr>
        <?php
            foreach($rows as $row){
            ?>
            <tr>
                <td><?=$row['TenXe']?>
            </td>
                <td><input id="form1" min="0" 
                name="Số lượng xe mua" value="<?=$row['Soluongxe']?>" 
                type="number" class="form-control form-control-sm">
            </td>
                <td><h6 class="mb-0">
                    <?php
                    $total = $row['Soluongxe'] * $row['Giatien'];
                    echo $total;
                    ?>
                    </h6>
                </td>
                <td><a href="shopcart.php?del_Magiohang=<?=$row['Magiohang']?>"
                 class="text-muted text-decoration-none">x</td>
            </tr>
            <?php
            }
            ?>
    </table>
        <hr class="my-4">
        <div class="col-6 d-grid mx-auto">
            <button type="button" name="btnPay" class="btn btn-primary btn-rounded-pill" onclick="location.href='pay.php';" <?=$disabled?>>
                Thanh toán
            </button>
        </div>
        <div class="pt-5">
            <h6 class="mb-0"><a href="home.php" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Quay lại trang chủ</a></h6>
        </div>
</div>