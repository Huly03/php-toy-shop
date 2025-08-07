<?php
    $conn = mysqli_connect("localhost", "root", "", "xedochoi") or die("Connect fail!");
    mysqli_query($conn,"SET NAMES 'utf8'");

    // Kiểm tra nếu yêu cầu POST có chứa mã quản lý đơn hàng
    if (isset($_POST['maqldonhang'])) {
        // Lấy mã quản lý đơn hàng từ yêu cầu POST
        $maqldonhang = $_POST['maqldonhang'];

        // Tạo câu truy vấn SQL để cập nhật cột Tinhtrang từ 0 thành 1
        $sql = "UPDATE `quanlydonhang` SET `Tinhtrang` = 1 WHERE `Maqldonhang` = $maqldonhang";

        // Thực thi câu truy vấn SQL
        $query = mysqli_query($conn,$sql);

        // Kiểm tra nếu câu truy vấn thành công
        if ($query) {
            echo "<script>
            alert ('Đơn hàng đã được duyệt');
            window.location.href = 'oder_management.php';
            </script>";
        } else {
            echo "Không có mã quản lý đơn hàng!";
            echo "<button onclick=\"history.back ()\">Quay về trang quản lý đơn hàng</button>";
        }
    }
?>
