<!DOCTYPE html> 
<html> 
	<head> 
		<title>Menu</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<link rel="stylesheet" href="../common/jquery/css/themes/default/jquery.mobile-1.4.5.min.css" />
		<link rel="stylesheet" href="../common/style.css" />
		<script type="text/javascript" src="../common/jquery/js/jquery.min.js"></script>
		<script type="text/javascript" src="../common/jquery/js/jquery.mobile-1.4.5.js"></script>
		<script type="text/javascript">

		function shutdown() {
			$.post("menu_controller.php", {Command: "shutdown"});
			alert("Wait few seconds and remove power.");
		}

		</script>
	</head> 
	<body> 
		<div data-role="page">
			<br>
			<center><h1>Web app</h1></center>
			<div data-role="content"> 
				<br>
				<a href="../setup" class="ui-btn ui-icon-gear ui-btn-icon-right" data-ajax="false">Setup</a>
				<br>
				<a href="../control" class="ui-btn ui-icon-grid ui-btn-icon-right" data-ajax="false">Control</a>
				<br><br>
				<a onClick="shutdown()" class="ui-btn ui-icon-power ui-btn-icon-right" style = "background: red;color: white;" data-ajax="false">SYSTEM SHUTDOWN</a>
			</div>
		</div>
	</body>
</html>