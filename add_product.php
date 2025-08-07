<?php
require_once('header_admin.php');
require_once('connect.php');

if (isset($_POST['btnAddProduct'])) {
    $c = new Connect();
    $dbLink = $c->connectToPDO();

    $pid = $_POST['Maxe'];
    $pname = $_POST['TenXe'];
    $pprice = $_POST['Giatien'];
    $pquan = $_POST['Soluong'];
    $pdesc = $_POST['Thongtinxe'];
    $pimage = str_replace(' ', '-', $_FILES['Hinhanh']['name']);
    $imgdir = './img/';
    $flag = move_uploaded_file($_FILES['Hinhanh']['tmp_name'], $imgdir . $pimage);
    $pdate = date('Y-m-d');  // Use the current date
    $catid = $_POST['Theloai'];

    if ($flag) {
        $sql = "INSERT INTO xe (Maxe, TenXe, Giatien, Soluong, Thongtinxe, Hinhanh, Ngaynhap, Theloai) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $re = $dbLink->prepare($sql);
        $re->execute([$pid, $pname, $pprice, $pquan, $pdesc, $pimage, $pdate, $catid]);

        echo "Thêm xe thành công.";
    } else {
        echo "Thêm xe thất bại.";
    }
}


$c = new connect();
$dbLink = $c->connectToMySQL();
$sql = 'SELECT * FROM xe x ';
$re = $dbLink->query($sql);
?>
<div class="container">
    <h2>Thêm xe</h2>
    <form class="form form-vertical" method="POST" action="#" enctype="multipart/form-data">
        <!-- Your product input fields here -->
        <div class="row mb-3">
            <div class="row mb-3">
                <label for="Maxe" class="col-sm-2">Mã xe:</label>
                <div class="col-sm-10">
                    <input id="Maxe" type="text" name="Maxe" class="form-control" value="">
                </div>
            </div>

            <div class="row mb-3">
                <label for="Tenxe" class="col-sm-2">Tên xe:</label>
                <div class="col-sm-10">
                    <input id="TenXe" type="text" name="TenXe" class="form-control" value="">
                </div>
            </div>

            <div class="row mb-3">
                <label for="Giatien" class="col-sm-2">Giá tiền:</label>
                <div class="col-sm-10">
                    <input id="Giatien" type="number" name="Giatien" class="form-control" value="">
                </div>
            </div>

            <div class="row mb-3">
                <label for="Soluong" class="col-sm-2">Số lượng:</label>
                <div class="col-sm-10">
                    <input id="Soluong" type="number" name="Soluong" class="form-control" value="">
                </div>
            </div>

            <div class="row mb-3">
                <label for="Thongtinxe" class="col-sm-2">Thông tin xe:</label>
                <div class="col-sm-10">
                    <input id="Thongtinxe" type="text" name="Thongtinxe" class="form-control" value="">
                </div>
            </div>

            <div class="row mb-3">
                <label for="Hinhanh" class="col-sm-2">Hình ảnh:</label>
                <div class="col-sm-10">
                    <input id="Hinhanh" type="file" name="Hinhanh" class="form-control" value="">
                </div>
            </div>

            <div class="row mb-3">
                <label for="Ngaynhap" class="col-sm-2">Ngày nhập: </label>
                <div class="col-sm-10">
                    <input type="Ngaynhap" id="pdate" name="Ngaynhap" class="form-control" value="">
                </div>
            </div>

            <div class="row mb-3">
                <label for="Theloai" class="col-sm-2">Thể loại:</label>
                <div class="col-sm-10">
                    <input id="Theloai" type="text" name="Theloai" class="form-control" value="">
                </div>
            </div>
        </div>
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
    </form>
</div>

<?php
require_once('footer.php');
?>