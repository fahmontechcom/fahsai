<?php
session_start();
$user = $_SESSION['user'];

if($user == ""){
	?>
	<script >window.location="../index.php";</script>
	<?PHP
}




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
		<div id="page-content-wrapper">
			<?php require_once("views/body.inc.php"); ?>
		</div>
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
</html> 