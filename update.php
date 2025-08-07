<?php
require_once('header_admin.php');
include_once('connect.php');
$c = new Connect();
$dbLink = $c->connectToMySQL();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['Maxe'];
    $product_name = $_POST['TenXe'];
    $price = $_POST['Giatien'];
    $quantity = $_POST['Soluong'];
    $des = $_POST['Thongtinxe'];
    $img = $_POST['Hinhanh'];
    $date = $_POST['Ngaynhap'];
    $catID = $_POST['Theloai'];

    $sql = " UPDATE `xe` SET
     `Maxe`='$product_id',
     `TenXe`='$product_name',
     `Thongtinxe`='$des',
     `Hinhanh`='$img',
     `Soluong`='$quantity',
     `Theloai`='$catID',
     `Giatien`='$price',
     `Ngaynhap`='$date'
     WHERE Maxe = '$product_id'";

    if ($dbLink->query($sql) === true) {
        echo "Cập nhật thành công.";
    } else {
        echo "Lỗi: " . $sql . $dbLink->error;
    }
}


$product_id = $_GET['Maxe'];
$sql = "SELECT * FROM xe WHERE Maxe = '$product_id'";
$result = $dbLink->query($sql);
$row = $result->fetch_assoc();

?>

<div class="container">
    <h2>Cập nhật xe</h2>
    <form class="form form-vertical" method="POST" action="#" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="row mb-3">
                <label for="Maxe">Mã xe:</label>
                <div class="col-sm-10">
                    <input id="Maxe" type="text" name="Maxe" class="form-control" value="<?= $row['Maxe'] ?>" required>
                </div>
            </div>
            <div class="row mb-3">

                <label for="TenXe">Tên xe:</label>
                <div class="col-sm-10">
                    <input id="TenXe" type="text" name="TenXe" class="form-control" value="<?= $row['TenXe'] ?>" required>
                </div>

            </div>
            <div class="row mb-3">

                <label for="Thongtinxe">Thông tin xe:</label>
                <div class="col-sm-10">
                    <input id="Thongtinxe" type="text" name="Thongtinxe" class="form-control" value="<?= $row['Thongtinxe'] ?>" required>
                </div>

            </div>
            <div class="row mb-3">

                <label for="Giatien">Giá tiền: </label>
                <div class="col-sm-10">
                    <input id="Giatien" type="number" name="Giatien" class="form-control" value="<?= $row['Giatien'] ?>" required>
                </div>

            </div>
            <div class="row mb-3">

                <label for="Soluong">Số lượng:</label>
                <div class="col-sm-10">
                    <input id="Soluong" type="text" name="Soluong" class="form-control" value="<?= $row['Soluong'] ?>" required>
                </div>

            </div>
            <div class="row mb-3">
                <!-- <div class="row mb-3"> -->

                <label for="Theloai">Thể loại:</label>
                <div class="col-sm-10">
                    <input id="Theloai" type="text" name="Theloai" class="form-control" value="<?= $row['Theloai'] ?>" required>
                </div>

            </div>
            <div class="row mb-3">
                <!-- <div class="row mb-3"> -->

                <label for="Ngaynhap">Ngày nhập:</label>
                <div class="col-sm-10">
                    <input id="Ngaynhap" type="text" name="Ngaynhap" class="form-control" value="<?= $row['Ngaynhap'] ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <!-- <div class="row mb-3"> -->

                <label for="Hinhanh
                
                ">Hình ảnh:</label>
                <div class="col-sm-10">
                    <input id="Hinhanh" type="text" name="Hinhanh" class="form-control" value="<?= $row['Hinhanh'] ?>" required>
                </div>
            </div>
    
            <br>
            <div class="row mb-3">
                <div class="col-2 mx-auto">
                    <input type="submit" name="btnAddProduct" value="Xác nhận" class="btn btn-primary">
                </div>
            </div>
            <hr class="my-4">

            <div class="pt-5">
                <h6 class="mb-0"><a href="admin.php" class="text-body">
                        <i class="fas fa-long-arrow-alt-left me-2"></i>Quay lại trang chủ</a>
                </h6>
            </div>
        </div>
    </form>
</div>

<?php
require_once('footer.php');
?>