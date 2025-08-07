<?php
require_once('header_admin.php');
require_once('connect.php');
?>
<!DOCTYPE html>  
 <html>  
    <head>
		<title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
		<style>
			.table-responsive{
				box-shadow: 0px 0px 5px #999;
				padding: 20px;
        	}
		</style>
	</head>  
    <body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<br />  
					<h1>Danh sách đơn hàng</h1><br />
					<div class="table-responsive">
						<table id="dataid" class="table table-striped table-bordered" style="width: 100%;">
							<thead>
								<tr>
                                <th>Mã quản lý đơn</th>
                                <th>Mã đơn hàng</th>
                                <th>Tên đăng nhập</th>
                                <th>Tên khách hàng</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Phương thức thanh toán</th>
								<th>Mã xe</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt</th>
                                <th>Tình trạng</th>
                                <th>Hành động</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$conn = mysqli_connect("localhost", "root", "", "xedochoi") or die("Connect fail!");
								mysqli_query($conn,"SET NAMES 'utf8'");

								$sql = "SELECT * FROM `quanlydonhang` ORDER BY `Maqldonhang` DESC";
								$query = mysqli_query($conn,$sql);

                                while ($row = mysqli_fetch_assoc($query)) {
                                    switch ($row['Tinhtrang']) {
                                        case 0:
                                            $row['Tinhtrang'] = 'Chưa duyệt';
                                            break;
                                        case 1:
                                            $row['Tinhtrang'] = 'Đã duyệt';
                                            break;
                                        default:
                                            $row['Tinhtrang'] = 'Không xác định';
                                            break;
                                    }
							?>
								<tr>
									<td><?php echo $row['Maqldonhang'] ?></td>
									<td><?php echo $row['Madonhang'] ?></td>
									<td><?php echo $row['Username'] ?></td>
									<td><?php echo $row['Tenkhachhang'] ?></td>
                                    <td><?php echo $row['SDT'] ?></td>
                                    <td><?php echo $row['Diachi'] ?></td>
                                    <td><?php echo $row['Phuongthucthanhtoan'] ?></td>
									<td><?php echo $row['Maxe'] ?></td>
                                    <td><?php echo $row['Tongtien'] ?></td>
                                    <td><?php echo $row['Ngaydat'] ?></td>
                                    <td><?php echo $row['Tinhtrang'] ?></td>
                                    <td>
                                        <?php if ($row['Tinhtrang'] == 'Chưa duyệt') { ?>
                                            <form method="post" action="approve.php">
                                                <input type="hidden" name="maqldonhang" value="<?php echo $row['Maqldonhang'] ?>">
                                                <input type="submit" name="approve" value="Duyệt đơn hàng">
                                            </form>
                                        <?php } ?>
										<form method="post" action="delete.php">
											<input type="hidden" name="Maqldonhang" value="<?php echo $row['Maqldonhang'] ?>">
											<input type="submit" name="delete" value="Xoá đơn hàng">
										</form>
                                    </td>
								</tr>
							<?php 
								} 
							?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-sm-2"></div>
			</div>
		</div>
	</body>
</html>
<script>
	$(document).ready(function() {
		var datatablephp = $('#dataid').DataTable();
	});
</script>
