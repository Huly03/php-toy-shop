<?php
require_once('header.php');
require_once('connect.php');
if(isset($_POST['btnRegister'])){
    $c = new Connect();
    $dbLink = $c->connectToPDO();
    $uname =$_POST['Username'];
    $upass =$_POST['Password'];
    $uphone =$_POST['SDT'];
    $uemail =$_POST['Email'];
    $ugender =$_POST['GioiTinh'];
    $uhometown =$_POST['Diachi'];
    $ubirthday = date('y-m-d',strtotime($_POST['Ngaysinh']));

    if (empty($_POST['pwd2'])) {
        
        echo "<script>window.alert('Bạn chưa nhập xác nhận mật khẩu!')
            window.location.href = 'register.php';
        </script>";
        exit();
    }

    if ($upass != $_POST['pwd2']) {
        echo "<script>window.alert('Mật khẩu bạn nhập không khớp!')
            window.location.href = 'register.php';
        </script>";
        exit();
    }
    if (empty($uphone)) {
        echo "<script>window.alert('Bạn phải nhập số điện thoại!')
            window.location.href = 'register.php';
        </script>";
        exit();
    }
    //$upass = password_hash($upass, PASSWORD_DEFAULT);

    // Kiểm tra Username đã tồn tại hay chưa
    $sql_check = "SELECT COUNT(*) as count FROM user WHERE Username = ?";
    $re_check = $dbLink->prepare($sql_check);
    $re_check->execute([$uname]);
    $row_check = $re_check->fetch(PDO::FETCH_ASSOC);
    if ($row_check['count'] > 0) {
        // Nếu Username đã tồn tại, hiển thị thông báo và dừng chương trình
        echo "<script>window.alert('Username đã tồn tại, vui lòng chọn Username khác!')
            window.location.href = 'register.php';
        </script>";
        exit();
    }

    // Nếu Username chưa tồn tại, tiếp tục thực hiện đăng ký
    $sql = "INSERT INTO `user`(`Username`, `Password`, `GioiTinh`, `NgaySinh`, `Diachi`, `SDT`, `Email`) VALUES (?,?,?,?,?,?,?)";

    $re = $dbLink->prepare($sql);
    $valueArray = [
        "$uname","$upass","$ugender","$ubirthday","$uhometown", "$uphone","$uemail"
    ];
    $stmt = $re->execute($valueArray);
    if($stmt){
        echo "<script>window.alert('Đăng ký thành công!')
            window.location.href = 'login.php';
        </script>";
        //echo "Đăng ký thành công";
    }else{
        echo "<script>window.alert('Đăng ký thất bại!')
            window.location.href = 'register.php';
        </script>";
        //echo "Đăng ký thất bại";
    }

}
?>


<div class="container">
                <h2>Đăng ký thành viên</h2>
                <form id="formreg" class="formreg" name="formreg" role="form" method="POST">
                    <div class="row mb-3">
                        <label for="Username" class="col-sm-2">Tên tài khoản:</label>
                        <div class="col-sm-10">
                                <input id="Username" type="text" name="Username" class="form-control" value="">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="Password" class="col-sm-2">Mật khẩu:</label>
                        <div class="col-sm-10">
                                <input id="Password" type="password" name="Password" class="form-control" value="">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for ="pwd2" class="col-sm-2">Xác nhận mật khẩu:</label>
                        <div class="col-sm-10">
                            <input id="pwd2" type="password" name="pwd2" class="form-control" value="">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="GioiTinh" id="GioiTinh" class="col-sm-2">Giới tính:</label>
                        <div class="col-sm-10 my-auto">
                            <div class="form-check d-inline-flex pe-3">
                                <input id="rMale" type="radio" name="GioiTinh" value="0" class="form-check-input">
                                <label for="rMale" class="form-check-label">Nam</label>
                            </div>

                            <div class="form-check d-inline-flex">
                                <input id="rFemale" type="radio" name="GioiTinh" value="1" class="form-check-input">
                                <label for="rFemale" class="form-check-label">Nữ</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="SDT" class="col-sm-2">Số điện thoại:</label>
                        <div class="col-sm-10">
                            <input id="SDT" type="number" name="SDT" class="form-control" value="">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <lable for="Email" class="col-sm-2">Email:</lable>
                        <div class="col-sm-10">
                            <input id="Email" type="email" name="Email" class="form-control" value="">
                        </div>
                    </div>

                    <!--Birthday-->
                    <div class="row mb-3">
                        <label for="Ngaysinh" class="col-sm-2">Ngày sinh: </label>
                        <div class="col-sm-10">
                            <input type="Ngaysinh" id="txtBirth" name="Ngaysinh" class="form-control" value="">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="Diachi" class="col-sm-2">Nơi sinh sống:</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="Diachi" name="Diachi" required>
                                <option selected value="">Chọn tỉnh</option>
                                <option value="ct">Can Tho</option>
                                <option value="cm">Ca Mau</option>
                                <option value="hg">Hau Giang</option>
                                <option value="st">Soc Trang</option>
                            </select>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <!--<div class="col-sm-10 ms-auto"-->
                        <div class="d-grid col-2 mx-auto">
                            <input type="submit" name="btnRegister" value="Đăng ký" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
<?php
require_once('footer.php');
?>