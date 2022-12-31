<?php
// Include calendar helper functions
require_once 'functions.php';
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Event Calendar</title>
<meta charset="utf-8">

<!-- Stylesheet file -->
<link rel="stylesheet" href="css/style.css">

<!-- jQuery library -->
<script src="js/jquery.min.js"></script>

<!-- SweetAlert plugin to display alert -->
<script src="js/sweetalert.min.js"></script>
</head>
<body>
	<!-- Display event calendar -->
	<div id="calendar_div">
		<?php echo getCalender(); ?>
	</div>
</body>
</html>