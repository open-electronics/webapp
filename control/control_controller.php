<?php

	require_once "../common/db.php";

	if(isset($_POST["Command"])) {
		$Command = trim($_POST["Command"]);
	} else {
		$Command = "";
	}

	if(isset($_POST["param"])) {
		$param = $_POST["param"];
	} else {
		$param = [];
	}
	
	$db = new Db();
	$db->OpenDb();
	
	//	Sensors
	
	if($Command == "loadSensors") {
		$response = array();
		$i = 0;
		$sql = "SELECT id, name, eid_relay, target, relay_status, relay_seconds FROM sensors ORDER BY id";
		$result = $db->QueryDb($sql);
		while($row = $result->fetch_assoc()) {
			$response[$i]["ID"] = trim($row['id']);
			$response[$i]["Name"] = trim($row['name']);
			$response[$i]["Target"] = "<option value='1' ".($row['target'] == 1 ? "selected" : "").">HIGH</option><option value='0'".($row['target'] == 0 ? "selected" : "").">LOW</option></select>";
			$response[$i]["Status"] = "<option value='1' ".($row['relay_status'] == 1 ? "selected" : "").">ON</option><option value='0'".($row['relay_status'] == 0 ? "selected" : "").">OFF</option></select>";
			$response[$i]["Seconds"] = trim($row['relay_seconds']);
			if($row['eid_relay'] == null || $row['eid_relay'] == 0) {
				$response[$i]["Content"] = "<option value='0' selected>--</option>";
			} else {
				$response[$i]["Content"] = "<option value='0'>--</option>";
			}
			$sql = "SELECT id, name FROM relays ORDER BY name";
			$res = $db->QueryDb($sql);
			while($rw = $res->fetch_assoc()) {
				if($row['eid_relay'] == $rw['id']) {
					$response[$i]["Content"] .= "<option value='".trim($rw['id'])."' selected>".trim($rw['name'])."</option>";
				} else {
					$response[$i]["Content"] .= "<option value='".trim($rw['id'])."'>".trim($rw['name'])."</option>";
				}
			}
			$i++;
		}
		echo json_encode($response);
	}
	
	if($Command == "updateSensor") {
		$sql = "UPDATE sensors SET target = '".$param["Target"]."', eid_relay = '".$param["Relay"]."', relay_status = '".$param["Status"]."', relay_seconds = '".$param["Seconds"]."' WHERE id = '".$param["ID"]."'";
		$result = $db->QueryDb($sql);
	}
	
	//	Relays
	
	if($Command == "loadRelays") {
		$response = array();
		$i = 0;
		$sql = "SELECT relays.id as id, relays.name as name, status, sensors.id as sensor FROM relays LEFT JOIN sensors ON (relays.id = sensors.eid_relay) ORDER BY id";
		$result = $db->QueryDb($sql);
		while($row = $result->fetch_assoc()) {
			$response[$i]["ID"] = trim($row['id']);
			$response[$i]["Name"] = trim($row['name']);
			$response[$i]["Status"] = trim($row['status']);
			$response[$i]["Sensor"] = trim($row['sensor']);
			$i++;
		}
		echo json_encode($response);
	}
	
	if($Command == "setRelay") {
		$sql = "UPDATE relays SET status = ".$param["Status"]." WHERE id = '".$param["ID"]."'";
		$result = $db->QueryDb($sql);
	}
	
	$db->CloseDb();
	
?>