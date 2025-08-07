<?php
// Define constants for database connection
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "xedochoi");

require_once('header_admin.php');
require_once('connect.php');
?>
<!DOCTYPE html>  
 <html>  
    <head>
		<title>Danh sách đơn hàng</title>
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
					<h1>Xem chi tiết đơn hàng</h1><br />
					<div class="table-responsive">
						<table id="dataid" class="table table-striped table-bordered" style="width: 100%;">
							<thead>
								<tr>
                                <th>Mã đơn hàng</th>
                                <th>Mã xe</th>
                                <th>Tên xe</th>
                                <th>Số lượng xe</th>
								</tr>
							</thead>
							<tbody>
							<?php
								// Create database connection using constants
								$db_conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Connect fail!");
								mysqli_query($db_conn,"SET NAMES 'utf8'");

                                $sql = "SELECT Madonhang, Maxe, TenXe, Soluongxe FROM quanlydonhang WHERE Tinhtrang = 1";								
								$query = mysqli_query($db_conn,$sql);

								// Check if query returns any data
								if (mysqli_num_rows($query) > 0) {
									// Fetch data and display in table
									while ($row = mysqli_fetch_assoc($query)) {
							?>
								<tr>
									<td><?php echo $row['Madonhang'] ?></td>
									<td><?php echo $row['Maxe'] ?></td>
									<td><?php echo $row['TenXe'] ?></td>
                                    <td><?php echo $row['Soluongxe'] ?></td>
								</tr>
							<?php 
									} 
								} else {
									// No data found, display a friendly message
									echo "<tr><td colspan='4'>Không có đơn hàng nào trong cơ sở dữ liệu.</td></tr>";
								}
								// Close database connection
								mysqli_close($db_conn);
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
