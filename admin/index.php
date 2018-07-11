<?php
session_start();
$user = $_SESSION['user'];
require_once('../models/NotificationModel.php');
if($user == ""){
	?>
	<script >window.location="../index.php";</script>
	<?PHP
}
$model_notification = new NotificationModel;
$notifications = $model_notification->getNotificationBy($user[0][0]);

$notifications_new = $model_notification->getNotificationBy($user[0][0],"1");
$page = $_REQUEST['content'];
// to change a session variable, just overwrite it
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once('views/head.inc.php') ?>
</head>
<body>
	<!-- <div id="wrapper" class="toggled"> -->
		<?php require_once('views/header.inc.php') ?>

		<!-- Sidebar -->
		<?php require_once('views/menu.inc.php') ?>
		<!-- /#sidebar-wrapper -->

		<!-- Page Content -->
		<div id="page-content-wrapper" style="background-color:white;">
			<div style="padding:15px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
				<div id="main-content">
					<?php require_once("views/body.inc.php"); ?>
				</div>
			</div>
		</div>
		<?php require_once("views/footer.inc.php"); ?>
		<!-- /#page-content-wrapper -->

	<!-- </div> -->
	<!-- /#wrapper -->

	<!-- Menu Toggle Script -->
	<script>
		// $("#menu-toggle").click(function(e) {
		// 	e.preventDefault();
		// 	$("#wrapper").toggleClass("toggled");
		// });
	</script>
</body>


<script type="text/javascript" src="../template/date-picker/jquery-ui.min.js"></script>

<script type="text/javascript" src="../template/date-picker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="../template/date-picker/jquery-ui-sliderAccess.js"></script>


</html> 