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
		$sql = "SELECT id, name FROM sensors ORDER BY id";
		$result = $db->QueryDb($sql);
		while($row = $result->fetch_assoc()) {
			$response[$i]["ID"] = trim($row['id']);
			$response[$i]["Name"] = trim($row['name']);
			$i++;
		}
		echo json_encode($response);
	}
	
	if($Command == "updateSensor") {
		$sql = "UPDATE sensors SET name = '".$db->EscapeString(trim($param["Name"]))."' WHERE id = '".$param["ID"]."'";
		$result = $db->QueryDb($sql);
	}
	
	//	Relays
	
	if($Command == "loadRelays") {
		$response = array();
		$i = 0;
		$sql = "SELECT id, name FROM relays ORDER BY id";
		$result = $db->QueryDb($sql);
		while($row = $result->fetch_assoc()) {
			$response[$i]["ID"] = trim($row['id']);
			$response[$i]["Name"] = trim($row['name']);
			$i++;
		}
		echo json_encode($response);
	}
	
	if($Command == "updateRelay") {
		$sql = "UPDATE relays SET name = '".$db->EscapeString(trim($param["Name"]))."' WHERE id = '".$param["ID"]."'";
		$result = $db->QueryDb($sql);
	}
	
	$db->CloseDb();
	
?>