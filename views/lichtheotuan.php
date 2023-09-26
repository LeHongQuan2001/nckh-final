<div class="col-md-12">
  <?php include('calendar.php'); ?>
</div>
<div class="col-md-4">
<?php 
$type = $_SESSION['calendar_fd_user']['type'];
if($type == 'admin' || $type == 'giaovu') {
	include('eventform.php');
}
else {
	echo "&nbsp;";
}
?>	
</div>