
<DOCTYPE html>
    <html lange="en">
        <head>
            <title></title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
        </head>

    <?php
// Khởi tạo kết nối với cơ sở dữ liệu
require_once('connect.php');
$c = new Connect();
$dblink = $c->connectToPDO();

// Kiểm tra xem người dùng đã nhấn nút đăng nhập hay chưa
if (isset($_POST['btnLogin'])) {
    // Kiểm tra xem người dùng đã nhập tên đăng nhập và mật khẩu hay chưa
    if (!empty($_POST['Username']) && !empty($_POST['Password'])) {
        $username = $_POST['Username'];
        $password = $_POST['Password'];

        if ($username == "admin" && $password == "admin") {
            // Đăng nhập thành công
            echo "<script>window.alert('Đăng nhập thành công!')
            window.location.href = 'admin.php';
            </script>";
            //header("Location: admin.php");
        } else {
            // Ngược lại, kiểm tra tên đăng nhập và mật khẩu trong cơ sở dữ liệu
            $sql = "SELECT * FROM user WHERE Username = ? and Password = ?";
            $stmt = $dblink->prepare($sql);
            $sre = $stmt->execute(array("$username", "$password"));
            $numrow = $stmt->rowCount();
            $row = $stmt->fetch(PDO::FETCH_BOTH);

            if ($numrow == 1) {
                echo "<script>window.alert('Đăng nhập thành công!')
                window.location.href = 'home.php';
                </script>";
                setcookie("cc_Username",$row['Username'], time()+3600);
                //header("Location: home.php");
            } else {
                // Ngược lại, thông báo lỗi
                echo "<script>window.alert('Tên đăng nhập hoặc mật khẩu không chính xác, vui lòng nhập lại')</script>";
            }
        }
    } else {
        // Nếu người dùng không nhập tên đăng nhập hoặc mật khẩu, thông báo lỗi
        echo "<script>window.alert('Vui lòng nhập thông tin của bạn')</script>";
    }
}
?>

?>



<style>
    h2{
        text-align: center;
        margin: 20px;
        color: #fff;
        font-size: 50px;
    }
    body{
        background-image: url(https://wallpapers.com/images/high/light-blue-car-pastel-desktop-lnf2fl0j8gkfx653.webp);
        background-repeat: no-repeat;
        background-size: cover; 
        background-position: center; 
    }
    .container{
        padding: 0;
        margin-top: 200px;
    }
</style>
<body>
    <div class="container">
        <h2>Đăng nhập</h2>
        <form id="formreg" class="formreg" name="formreg" role="form" method="POST">
            <div class="row mb-3 my-auto">
                <div class="d-grid col-4 mx-auto">
                    <input id="Username" type="text" name="Username" class="form-control" value="" placeholder="Tên tài khoản">
                </div>
            </div>

            <div class="row mb-3">
                <div class="d-grid col-4 mx-auto">
                    <input id="Password" type="password" name="Password" class="form-control" value="" placeholder="Mật khẩu">
                </div>
            </div>

            <div class="row col-4 mb-3 mx-auto">
                <div class="col-6 d-grid mx-auto">
                    <button type="submit" name="btnLogin" class="btn btn-primary btn-rounded-pill">
                   Đăng nhập
                    </button>
                </div>

                <div class="col-6 d-grid mx-auto">
                    <button type="button" name="btnRegister" class="btn btn-primary btn-rounded-pill" onclick="location.href='register.php';">
                        Đăng ký
                    </button>
                </div>
            </div>

        </form>
</body>
</html>

