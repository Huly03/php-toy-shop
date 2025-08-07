<?php
require_once('header_admin.php');//goi noi dung
include_once('connect.php');//goi noi dung

$c = new Connect();
$dbLink = $c->connectToMySQL();//truy van k dieu kien
$sql = "Select Maxe, TenXe, Giatien FROM xe ";
$result = $dbLink->query($sql);

// Tạo một mảng để lưu trữ số lượng xe đã bán theo mã xe và ngày bán
$sold = array();

// Hiển thị tiêu đề trang
echo "<center><h1>Thống kê xe đã bán</h1></center>";

// Hiển thị một form HTML để cho phép người dùng nhập vào ngày bắt đầu và ngày kết thúc
echo "<form method='post' action=''>";
echo "<label for='ngaybatdau'>Ngày bắt đầu:</label>";
echo "<input type='date' id='ngaybatdau' name='ngaybatdau'>";
echo "<label for='ngayketthuc'>Ngày kết thúc:</label>";
echo "<input type='date' id='ngayketthuc' name='ngayketthuc'>";
echo "<input type='submit' value='Lọc'>";
echo "</form>";

// Kiểm tra xem người dùng đã nhập vào ngày bắt đầu và ngày kết thúc chưa
if (isset($_POST['ngaybatdau']) && isset($_POST['ngayketthuc'])) {
  // Lấy ngày bắt đầu và ngày kết thúc từ form HTML
  $ngaybatdau = strtotime($_POST['ngaybatdau']);
  $ngayketthuc = strtotime($_POST['ngayketthuc']);


  // Sửa ngày bắt đầu và ngày kết thúc theo định dạng yyyy/mm/dd
  // Chuyển đổi ngày bắt đầu và ngày kết thúc từ dạng chuỗi sang dạng DateTime object
  $ngaybatdau = date('d/m/Y', $ngaybatdau);
  $ngayketthuc = date('d/m/Y', $ngayketthuc);
  // Bảo vệ các biến trong câu truy vấn SQL
  $ngaybatdau = mysqli_real_escape_string($dbLink, $ngaybatdau);
  $ngayketthuc = mysqli_real_escape_string($dbLink, $ngayketthuc);
  
  
  // Kiểm tra xem ngày bắt đầu có nhỏ hơn hoặc bằng ngày kết thúc không
  if ($ngaybatdau <= $ngayketthuc) {
    // Truy vấn bảng order_count để lấy số lượng xe đã bán và ngày bán
    // Thêm điều kiện để chỉ lấy những đơn hàng đã duyệt và nằm trong khoảng ngày bắt đầu và ngày kết thúc
    $sql2 = "Select Maxe, SUM(Soluongxe) as total, Ngaydat FROM quanlydonhang WHERE Tinhtrang = 1 AND Ngaydat BETWEEN '$ngaybatdau' AND '$ngayketthuc' GROUP BY Maxe, Ngaydat";
    $result2 = $dbLink->query($sql2);

    // Kiểm tra xem có xe nào được bán trong khoảng thời gian đó không
    if (mysqli_num_rows($result2) > 0) {
      // Lặp qua kết quả và lưu trữ vào mảng sold
      while ($row2 = $result2->fetch_assoc()) {
        // Sử dụng một mảng hai chiều để lưu trữ số lượng xe và ngày bán theo mã xe
        $sold[$row2['Maxe']][$row2['Ngaydat']] = $row2['total'];
      }

      // Hiển thị một bảng với các cột là mã xe, tên xe, giá tiền, ngày bán và số lượng đã bán
      echo "<table id='staff' border='1'>";
      echo "<thead><tr><th>Tên xe</th><th>Giá tiền</th><th>Ngày đặt xe</th><th>Số lượng đã bán</th></tr></thead>";
      echo "<tbody>";

      // Lặp qua kết quả từ bảng xe và hiển thị các giá trị tương ứng
      // Lặp qua kết quả từ bảng xe và hiển thị các giá trị tương ứng
      while ($row = $result->fetch_assoc()) {
        // Kiểm tra xem có ngày đặt xe khác 0 không
        if (array_key_exists($row['Maxe'], $sold) && count($sold[$row['Maxe']]) > 0) {
            $bookName = $row['TenXe'];
            $bookPrice = $row['Giatien'];

            $i = 0; // biến đếm số lần lặp
            foreach ($sold[$row['Maxe']] as $ngaydat => $total) {
              // Kiểm tra xem ngày đặt xe khác 0 không
              if ($ngaydat != '0') {
                  // nếu không phải lần lặp đầu tiên, tạo một dòng mới
                  if ($i > 0) {
                      echo "<tr>";
                  }
          
                  echo "<td>" . $bookName . "</td>";
                  echo "<td>" . $bookPrice . "</td>";
                  echo "<td>" . $ngaydat . "</td>";
                  echo "<td>" . $total . "</td>";
          
                  // tăng biến đếm
                  $i++;
          
                  // đóng dòng tr
                  echo "</tr>";
              }
          }          
        }
     }

      // Kết thúc bảng
      echo "</tbody>";
      echo "</table>";

      // Thêm code để sử dụng datatable và phân trang
      // Tham khảo: https://datatables.net/examples/basic_init/zero_configuration.html
      // Thêm thư viện jquery và datatable vào header_admin.php
      echo "<script src='https://code.jquery.com/jquery-3.5.1.js'></script>";
      echo "<script src='https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'></script>";
      echo "<link rel='stylesheet' href='https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css'>";

      // Khởi tạo datatable cho bảng staff
      echo "<script>";
      echo "$(document).ready(function() {";
      echo "$('#staff').DataTable();";
      echo "} );";
      echo "</script>";
    } else {
      // Nếu không có xe nào được bán trong khoảng thời gian đó, hiển thị một thông báo cho người dùng biết
      echo "<p>Không có xe nào được bán trong khoảng thời gian từ $ngaybatdau đến $ngayketthuc.</p>";    }
    } else {
      // Nếu ngày bắt đầu lớn hơn ngày kết thúc, hiển thị một thông báo lỗi và yêu cầu người dùng nhập lại
      echo "<p>Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc. Vui lòng nhập lại.</p>";
    }
    
    } else {
      // Nếu người dùng chưa nhập vào ngày bắt đầu và ngày kết thúc, hiển thị một thông báo yêu cầu người dùng chọn lọc
      echo "<p>Vui lòng chọn ngày bắt đầu và ngày kết thúc để xem thống kê xe đã bán được.</p>";
    }
?>
