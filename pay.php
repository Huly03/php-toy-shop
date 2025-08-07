<?php
session_start();
require_once('header.php');
include_once("connect.php");

$c = new Connect();
$dblink = $c->connectToPDO();

// Lấy thông tin người dùng từ cookie
if(isset($_COOKIE['cc_Username'])){
    $user = $_COOKIE['cc_Username'];
    
    // Lấy thông tin giỏ hàng từ bảng giohang
    $sql = "SELECT * FROM giohang gh, xe x WHERE gh.Maxe = x.Maxe and gh.Username = '$user'";
    $stmt = $dblink->prepare($sql);
    $stmt->execute();

    $numrow = $stmt->rowCount();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Tạo một mảng để lưu trữ thông tin giỏ hàng
    $cart = array();

    $total = 0;
    $soluongxe_final = [];

    if ($numrow > 0) {
      // Lặp qua các dòng kết quả và thêm vào mảng giỏ hàng
        foreach ($row as $k => $value) {
          $cart[] = $value;
          $total += $row[$k]['Soluongxe'] * $row[$k]['Giatien'];
          $soluongxe_final[] =  Array(
            'maxe' => $row[$k]['Maxe'],
            'soluong' => $row[$k]['Soluong'] - $row[$k]['Soluongxe']
          );
      }
       
    } else {
      echo "Giỏ hàng của bạn đang trống";
    }

    // Xử lý khi người dùng nhấn nút thanh toán
    
    if (isset($_POST['btnPay'])) {
      // Lấy phương thức thanh toán từ form
      $Tenkhachhang = $_POST['Tenkhachhang'];
      $SDT = $_POST['SDT'];
      $Diachi = $_POST['Diachi'];
      $Phuongthucthanhtoan = $_POST['Phuongthucthanhtoan'];
      // Tạo mã đơn hàng ngẫu nhiên
      $Madonhang = rand(000001, 999999);
      // Kiểm tra xem mã đơn hàng có trùng với mã đơn hàng nào đã có hay không
      $sql = "SELECT COUNT(*) FROM donhang WHERE Madonhang = '$Madonhang'";
      $stmt = $dblink->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetchColumn();
      // Nếu có trùng, tạo lại mã đơn hàng cho đến khi duy nhất
      while ($count > 0) {
        $Madonhang = rand(000001, 999999);
        $sql = "SELECT COUNT(*) FROM donhang WHERE Madonhang = '$Madonhang'";
        $stmt = $dblink->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
      }
      // Lấy ngày đặt hàng hiện tại
      $Ngaydat = date("d/m/Y");

      // Thêm thông tin đơn hàng vào bảng donhang
      $sql = "INSERT INTO donhang (Madonhang, Username, Tenkhachhang, SDT, Diachi, Phuongthucthanhtoan, Tongtien, Ngaydat) VALUES ('$Madonhang', '$user', '$Tenkhachhang', '$SDT', '$Diachi', '$Phuongthucthanhtoan', '$total', '$Ngaydat')";
      $stmt = $dblink->prepare($sql);
      if ($stmt->execute() === TRUE) {
        foreach ($cart as $item) {
          $Maxe = $item['Maxe'];
          $Soluongxe = $item['Soluongxe'];
          $TenXe = $item['TenXe'];
          $sql = "INSERT INTO quanlydonhang (Madonhang, Username, Tenkhachhang, SDT, Diachi, Phuongthucthanhtoan, Maxe, TenXe, Soluongxe, Tongtien, Ngaydat, Tinhtrang) VALUES ('$Madonhang', '$user', '$Tenkhachhang', '$SDT', '$Diachi', '$Phuongthucthanhtoan',  '$Maxe', '$TenXe', '$Soluongxe', '$total', '$Ngaydat','0')";
          $stmt = $dblink->prepare($sql);
          $stmt->execute();
        }
        foreach ($soluongxe_final as $key => $value) {
          $sql = "UPDATE xe SET Soluong = ".$value['soluong']. " WHERE Maxe = ". $value['maxe'];
          $stmt = $dblink->prepare($sql);
          $stmt->execute();
        }       
        echo "<script>alert('Đơn hàng đã được đặt thành công!'); window.location.href='home.php';</script>";
      } else {
        echo  "Lỗi thêm đơn hàng thất bại" ;
      }

      //Lặp qua các sản phẩm trong giỏ hàng
      foreach ($cart as $item) {
        // Lấy mã giỏ hàng và mã xe
        $Magiohang = $item['Username'];
        $Maxe = $item['Maxe'];

        // Xóa sản phẩm khỏi giỏ hàng
        $sql = "DELETE FROM giohang WHERE Username = '$Magiohang'";
        $stmt = $dblink->prepare($sql);
        if ($stmt->execute() === FALSE) {
          echo "Lỗi không thể xoá ";
        } 
      }
    }
}else{
    // Nếu người dùng chưa đăng nhập, chuyển đến trang đăng nhập
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Trang thanh toán</title>
</head>
<body>
  <div class="container">
    <h1 class="fw-bold mb-0 text-black">Trang thanh toán</h1>

    <!-- <h6 class="mb-0 text-muted"><?=$stmt->rowCount() ?></h6> -->
    <form method="post" action="pay.php"><table class="table">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
        </tr>
        <?php
            // Hiển thị thông tin giỏ hàng
            foreach($cart as $item){
            ?>
            <tr>
                <td><?=$item['TenXe']?>
            </td>
                <td><?=$item['Soluongxe']?>
            </td>
                <td><?=$item['Giatien']?>
            </td>
                <td><h6 class="mb-0">
                    <?php
                    $subtotal = $item['Soluongxe'] * $item['Giatien'];
                    echo $subtotal;
                    ?>
                    </h6>
                </td>
            </tr>
            <?php
            }
            ?>
    </table>
    <hr class="my-4">
    <div class="row">
      <div class="col-6">
        <h5 class="fw-bold mb-0 text-black">Thông tin khách hàng</h5>
        <p class="mb-0 text-muted"> Tên khách hàng: <input type='text' class='form-control' id='Tenkhachhang' name='Tenkhachhang' required></p>
        <p class="mb-0 text-muted">Số điện thoại: <input type='number' class='form-control' id='SDT' name='SDT' required></p>
        <p class="mb-0 text-muted">Địa chỉ: <input type='text' class='form-control' id='Diachi' name='Diachi' required></p>
      </div>
      <div class="col-6">
        <h5 class="fw-bold mb-0 text-black">Tổng tiền: <?=$total?></h5>
        <form method="post" action="pay.php">
          <div class="form-group">
            <label for="Phuongthucthanhtoan">Chọn phương thức thanh toán</label>
            <select id="Phuongthucthanhtoan" name="Phuongthucthanhtoan" class="form-control">
              <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
            </select>
          </div>
          <div class="form-group" style="text-align: center; margin-top: 30px;">
            <button type="submit" name="btnPay" class="btn btn-primary btn-rounded-pill" <?php if ($numrow == 0) { ?> disabled <?php } ?>>
                Xác nhận thanh toán
            </button>
          </div>
        </form>
      </div>
    </div>
    </form><div class="pt-5">
      <h6 class="mb-0"><a href="home.php" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Quay lại trang chủ</a></h6>
    </div>
  </div>
</body>
</html>
