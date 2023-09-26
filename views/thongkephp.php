<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
		</div>
	</nav>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h3 class="text-primary">PHP - Export Table Data As Excel</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal"><span class="glyphicon glyphicon-plus"></span> Add student</button>
		<br /><br />
		<table class="table table-bordered">
			<thead class="alert-info">
				<tr>
					<th>ID</th>
				<th>Ngày chấm</th>
					<th>Kế hoạch</th>
					<th>Thực giảng</th>
					<th>Chưa giảng dạy</th>
					<th>Lớp học</th>
					<th>Sĩ số</th>
					<th>Số SV có mặt</th>
					<th>Nội dung bài giảng</th>
					<th>Ghi chú</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$conn = new mysqli("localhost", "root", "", "db_event_management"); 
					$stt = 0;
					$sum = 0;
                            $sum1 = 0;
					$query = mysqli_query($conn, "SELECT * FROM `tbl_thoikhoabieu`") or die(mysqli_error());
					while($fetch = mysqli_fetch_array($query)){
						$stt++;
						$thucgiang = $fetch["Event"];
						if ($fetch["Event"] == 0) {
							$thucgiang = 0;
						} else {
							$thucgiang = $fetch["soTiet"];
						}
						if ($fetch["Event"] == 0) {
							$thieusot = $fetch["soTiet"];
						} else {
							$thieusot = 0;
						}
						$sum1 += $thieusot;
						$sum += $thucgiang;
				?>
				<tr>
				<th class="text-center"><?php echo $stt; ?></th>
				<td><?php echo $fetch["startDate"]; ?></td>
                                <td><?php echo $fetch["soTiet"]; ?></td>
                                <td> <?php echo $thucgiang; ?> </td>
                                <td> <?php echo $thieusot; ?> </td>
                                <td><?php echo $fetch["Location"]; ?></td>
                                <td> </td>
                                <td><?php echo $fetch["siSo"]; ?></td>
                                <td><?php echo $fetch["noiDung"]; ?></td>
                                <td><?php echo $fetch["nhanXet"]; ?></td>
                                <td></td>
                                <td></td>
				</tr>
				<?php
					}
				?>
			</tbody>
			<tfoot>
				<tr>
              <td>  <a href="<?php echo WEB_ROOT; ?>views/?v=EXPORT"></i><span>Save as Excel</span></a> </td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>	
<script src="js/jquery-3.2.1.min.js"></script>	
<script src="js/bootstrap.js"></script>	
</body>	
</html>