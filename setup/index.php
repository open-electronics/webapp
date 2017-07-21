<!DOCTYPE html> 
<html> 
	<head> 
		<title>Setup</title>
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<link rel="stylesheet" href="../common/jquery/css/themes/default/jquery.mobile-1.4.5.min.css" />
		<link rel="stylesheet" href="../common/style.css" />
		<script type="text/javascript" src="../common/jquery/js/jquery.min.js"></script>
		<script type="text/javascript" src="../common/jquery/js/jquery.mobile-1.4.5.js"></script>
		<script type="text/javascript">
		
			$( document ).ready(function() {
				loadSensors();
				loadRelays();
			});
		
			//	Sensors
			
			function loadSensors() {
				$.post("setup_controller.php", {Command: "loadSensors"}, function(response) {
					for(var s in response) {
						$("#SensorName_"+response[s]["ID"]).val(response[s]["Name"]);
						$("#SensorName_"+response[s]["ID"]).focusout(function() {
							updateSensor(this);
						});
					}
				}, "json");
			}
			
			function updateSensor(object) {
				
				var param = {};
				param["ID"] = object.id.replace("SensorName_", "");
				param["Name"] = object.value;
				$.post("setup_controller.php", {Command: "updateSensor", param});
				
			}
			
			//	Relays
			
			function loadRelays() {
				$.post("setup_controller.php", {Command: "loadRelays"}, function(response) {
					for(var s in response) {
						$("#RelayName_"+response[s]["ID"]).val(response[s]["Name"]);
						$("#RelayName_"+response[s]["ID"]).focusout(function() {
							updateRelay(this);
						});
					}
				}, "json");
			}
			
			function updateRelay(object) {
				
				var param = {};
				param["ID"] = object.id.replace("RelayName_", "");
				param["Name"] = object.value;
				$.post("setup_controller.php", {Command: "updateRelay", param});
				
			}
		
		</script>
	</head> 
	<body> 
		<div data-role="page">
			<div data-role="header" onClick = "location.replace('../menu');">
				<center><a href="../menu" class="ui-btn ui-shadow ui-corner-all ui-icon-home ui-btn-icon-notext">Home</a></center>
			</div>
		
			<div>
				<center><p><b>Setup</b></p></center>
			</div>

			<div data-role="tabs" id="tabs">
				<div data-role="navbar">
					<ul>
						<li><a class = "ui-btn-active" href="#SensorBox" data-ajax="false">Sensors</a></li>
						<li><a href="#RelayBox" data-ajax="false">Relays</a></li>
					</ul>
				</div>
				<div id="SensorBox" class="ui-body-d ui-content">
					<table class = "Box">
						<tr><th colspan = "2" style = "color: green;">Sensor 1</th></tr>
						<tr><td><b>Name:</b></td><td><input type="text" id = "SensorName_1" value="" maxlength="30"></td></tr>
					</table>
					<table class = "Box">
						<tr><th colspan = "2" style = "color: green;">Sensor 2</th></tr>
						<tr><td><b>Name:</b></td><td><input type="text" id = "SensorName_2" value="" maxlength="30"></td></tr>
					</table>
					<table class = "Box">
						<tr><th colspan = "2" style = "color: green;">Sensor 3</th></tr>
						<tr><td><b>Name:</b></td><td><input type="text" id = "SensorName_3" value="" maxlength="30"></td></tr>
					</table>
					<table class = "Box">
						<tr><th colspan = "2" style = "color: green;">Sensor 4</th></tr>
						<tr><td><b>Name:</b></td><td><input type="text" id = "SensorName_4" value="" maxlength="30"></td></tr>
					</table>
				</div>
				<div id="RelayBox" class="ui-body-d ui-content">
					<table class = "Box">
						<tr><th colspan = "2" style = "color: green;">Relay 1</th></tr>
						<tr><td><b>Name:</b></td><td><input type="text" id = "RelayName_1" value="" maxlength="30"></td></tr>
					</table>
					<table class = "Box">
						<tr><th colspan = "2" style = "color: green;">Relay 2</th></tr>
						<tr><td><b>Name:</b></td><td><input type="text" id = "RelayName_2" value="" maxlength="30"></td></tr>
					</table>
					<table class = "Box">
						<tr><th colspan = "2" style = "color: green;">Relay 3</th></tr>
						<tr><td><b>Name:</b></td><td><input type="text" id = "RelayName_3" value="" maxlength="30"></td></tr>
					</table>
					<table class = "Box">
						<tr><th colspan = "2" style = "color: green;">Relay 4</th></tr>
						<tr><td><b>Name:</b></td><td><input type="text" id = "RelayName_4" value="" maxlength="30"></td></tr>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>