<!DOCTYPE html> 
<html> 
	<head> 
		<title>Control</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<link rel="stylesheet" href="../common/jquery/css/themes/default/jquery.mobile-1.4.5.min.css" />
		<link rel="stylesheet" href="../common/style.css" />
		<script type="text/javascript" src="../common/jquery/js/jquery.min.js"></script>
		<script type="text/javascript" src="../common/jquery/js/jquery.mobile-1.4.5.js"></script>
		<script type="text/javascript">

			$(document).ready(function() {
				loadSensors();
				loadRelays();
			});
		
			//	Sensors
			
			function loadSensors() {
				$.post("control_controller.php", {Command: "loadSensors"}, function(response) {
					for(var s in response) {
						var id = response[s]["ID"];
						var name = response[s]["Name"];
						var content = response[s]["Content"];
						var target = response[s]["Target"];
						var status = response[s]["Status"];
						var seconds = response[s]["Seconds"];
						$("#SensorName_"+id).html($("#SensorName_"+id).html() + " " + name);
						$("#SensorRelay_"+id).html(content);
						$("#SensorRelay_"+id).selectmenu("refresh");
						$("#Target_"+id).html(target);
						$("#Target_"+id).selectmenu("refresh");
						$("#RelayStatus_"+id).html(status);
						$("#RelayStatus_"+id).selectmenu("refresh");
						$("#RelaySeconds_"+id).val(seconds);
					}
				}, "json");
			}
			
			function updateSensor(id) {
				var param = {};
				param["ID"] = id;
				param["Target"] = $("#Target_"+id).val();
				param["Relay"] = $("#SensorRelay_"+id).val();
				param["Status"] = $("#RelayStatus_"+id).val();
				param["Seconds"] = $("#RelaySeconds_"+id).val();
				$.post("control_controller.php", {Command: "updateSensor", param});
			}
			
			//	Relays

			setInterval(loadRelays(), 3000);
			
			function loadRelays() {
				$.post("control_controller.php", {Command: "loadRelays"}, function(response) {
					for(var s in response) {
						var id = response[s]["ID"];
						var name = response[s]["Name"];
						var status = response[s]["Status"];
						var sensor = response[s]["Sensor"];
						$("#RelayName_"+id).html("[" + id + "] " + name);
						$("#Relay_"+id).val(status);
						if(sensor != "") {
							$("#Relay_"+response[s]["ID"]).slider("disable");
						} else {
							$("#Relay_"+response[s]["ID"]).slider("enable");
						}
						$("#Relay_"+id).slider("refresh");
					}
				}, "json");
			}
			
			function setRelay(id) {
				var param = {};
				param["ID"] = id;
				param["Status"] = $("#Relay_"+id).val();
				$.post("control_controller.php", {Command: "setRelay", param});
			}
		
		</script>
	</head> 
	<body> 
		<div data-role="page">
			<div data-role="header" onClick = "location.replace('../menu');">
				<center><a href="../menu" class="ui-btn ui-shadow ui-corner-all ui-icon-home ui-btn-icon-notext">Home</a></center>
			</div>
		
			<div>
				<center><p><b>Control</b></p></center>
			</div>
			
			<div data-role="tabs" id="tabs">
				<div data-role="navbar">
					<ul>
						<li><a class = "ui-btn-active" href="#SensorBox" data-ajax="false">Auto</a></li>
						<li><a href="#RelayBox" data-ajax="false">Manual</a></li>
					</ul>
				</div>
				<div id="SensorBox" class="ui-body-d ui-content">
					<table class = "Box">
						<tr><td colspan = "3" style = "color: green; font-weight: bold;" id="SensorName_1">IF sensor [1]</td></tr>
						<tr><td><b>goes to</b></td><td colspan="2"><select id = "Target_1" data-mini="true" onChange = "updateSensor(1);"></td></tr>
						<tr><td><b>set relay </b></td><td colspan="2"><select id = "SensorRelay_1" data-mini="true" onChange = "updateSensor(1);"></select></td></tr>
						<tr><td><b>to</b></td><td colspan="2"><select id = "RelayStatus_1" data-mini="true" onChange = "updateSensor(1);"></td></tr>
						<tr><td width="10%"><b>for</b></td><td><input type="number" id = "RelaySeconds_1" value="0" maxlength="5" onfocusout = "updateSensor(1);"></td><td width="30%">seconds. (0=always)</td></tr>
					</table>
					<table class = "Box">
						<tr><td colspan = "3" style = "color: green; font-weight: bold;" id="SensorName_2">IF sensor [2]</td></tr>
						<tr><td><b>goes to</b></td><td colspan="2"><select id = "Target_2" data-mini="true" onChange = "updateSensor(2);"></td></tr>
						<tr><td><b>set relay </b></td><td colspan="2"><select id = "SensorRelay_2" data-mini="true" onChange = "updateSensor(2);"></select></td></tr>
						<tr><td><b>to</b></td><td colspan="2"><select id = "RelayStatus_2" data-mini="true" onChange = "updateSensor(2);"></td></tr>
						<tr><td width="10%"><b>for</b></td><td><input type="number" id = "RelaySeconds_2" value="0" maxlength="5" onfocusout = "updateSensor(2);"></td><td width="30%">seconds. (0=always)</td></tr>
					</table>
					<table class = "Box">
						<tr><td colspan = "3" style = "color: green; font-weight: bold;" id="SensorName_3">IF sensor [3]</td></tr>
						<tr><td><b>goes to</b></td><td colspan="2"><select id = "Target_3" data-mini="true" onChange = "updateSensor(3);"></td></tr>
						<tr><td><b>set relay </b></td><td colspan="2"><select id = "SensorRelay_3" data-mini="true" onChange = "updateSensor(3);"></select></td></tr>
						<tr><td><b>to</b></td><td colspan="2"><select id = "RelayStatus_3" data-mini="true" onChange = "updateSensor(3);"></td></tr>
						<tr><td width="10%"><b>for</b></td><td><input type="number" id = "RelaySeconds_3" value="0" maxlength="5" onfocusout = "updateSensor(3);"></td><td width="30%">seconds. (0=always)</td></tr>
					</table>
					<table class = "Box">
						<tr><td colspan = "3" style = "color: green; font-weight: bold;" id="SensorName_4">IF sensor [4]</td></tr>
						<tr><td><b>goes to</b></td><td colspan="2"><select id = "Target_4" data-mini="true" onChange = "updateSensor(4);"></td></tr>
						<tr><td><b>set relay </b></td><td colspan="2"><select id = "SensorRelay_4" data-mini="true" onChange = "updateSensor(4);"></select></td></tr>
						<tr><td><b>to</b></td><td colspan="2"><select id = "RelayStatus_4" data-mini="true" onChange = "updateSensor(4);"></td></tr>
						<tr><td width="10%"><b>for</b></td><td><input type="number" id = "RelaySeconds_4" value="0" maxlength="5" onfocusout = "updateSensor(4);"></td><td width="30%">seconds. (0=always)</td></tr>
					</table>
				</div>
				<div id="RelayBox" class="ui-body-d ui-content">
					<table class = "Box">
						<tr><td colspan = "2" style = "color: green; font-weight: bold;" id="RelayName_1">[1]</td></tr>
						<tr><td style = "width: 100px;"><b>Status:</b></td><td><select id="Relay_1" data-role="slider" onChange = "setRelay(1);"><option value="0">ON</option><option value="1">OFF</option></select></td></tr>
					</table>
					<table class = "Box">
						<tr><td colspan = "2" style = "color: green; font-weight: bold;" id="RelayName_2">[2]</td></tr>
						<tr><td style = "width: 100px;"><b>Status:</b></td><td><select id="Relay_2" data-role="slider" onChange = "setRelay(2);"><option value="0">ON</option><option value="1">OFF</option></select></td></tr>
					</table>
					<table class = "Box">
						<tr><td colspan = "2" style = "color: green; font-weight: bold;" id="RelayName_3">[3]</td></tr>
						<tr><td style = "width: 100px;"><b>Status:</b></td><td><select id="Relay_3" data-role="slider" onChange = "setRelay(3);"><option value="0">ON</option><option value="1">OFF</option></select></td></tr>
					</table>
					<table class = "Box">
						<tr><td colspan = "2" style = "color: green; font-weight: bold;" id="RelayName_4">[4]</td></tr>
						<tr><td style = "width: 100px;"><b>Status:</b></td><td><select id="Relay_4" data-role="slider" onChange = "setRelay(4);"><option value="0">ON</option><option value="1">OFF</option></select></td></tr>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>