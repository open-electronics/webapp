<?php

	/*
		SERIAL PROTOCOL:

		Command for relays: 0#[1-4]#[0/1]#@
		  0 = type: relay
		  [1-4] = related relay
		  [0/1] = set relay status
		  #@ = close and execute command
		  
		Command for sensors: 1#[1-4]#[1-4]#[0/1]#[0/1]#[0-N]#@
		  1 = type: sensor
		  [1-4] = related sensor
		  [1-4] = related relay
		  [0/1] = sensor target
		  [0/1] = set relay status
		  [0-N] = seconds
		  #@ = close and execute command
	
	*/
	
	require_once "common/db.php";
	require_once "common/PhpSerial.php";

	$db = new Db();
	$db->OpenDb();
	
	//	READ INITIAL STATUS OF ALL ELEMENTS
	
	$RelayStatus = array();
	$SensorStatus = array();
	
	//	Relays
	$sql = "SELECT id FROM relays ORDER BY id";
	$result = $db->QueryDb($sql);
	while($row = $result->fetch_assoc()) {
		$RelayStatus[$row['id']] = null;
	}
	
	//	Sensors
	$sql = "SELECT id FROM sensors ORDER BY id";
	$result = $db->QueryDb($sql);
	while($row = $result->fetch_assoc()) {
		$SensorStatus[$row['id']]["Relay"] = null;
		$SensorStatus[$row['id']]["Target"] = null;
		$SensorStatus[$row['id']]["Status"] = null;
		$SensorStatus[$row['id']]["Seconds"] = null;
	}
	
	
	$serial = new PhpSerial;

	$serial->deviceSet("/dev/ttyACM0");

	$serial->confBaudRate(9600);
	$serial->confParity("none");
	$serial->confCharacterLength(8);
	$serial->confStopBits(1);
	$serial->confFlowControl("none");

	if($serial->deviceOpen()) {

		sleep(2);
	
		while(1 == 1) {
			
			//	Relays
			$Status = 0;
			$sql = "SELECT id, status FROM relays ORDER BY id";
			$result = $db->QueryDb($sql);
			while($row = $result->fetch_assoc()) {
				$Status = trim($row['status']);
				if($Status != $RelayStatus[$row['id']]) {
					$serial->sendMessage("0#".trim($row['id'])."#".$Status."#@");
					$RelayStatus[$row['id']] = $Status;
				}
			}
			
			//	Sensors
			$sql = "SELECT id, eid_relay, target, relay_status, relay_seconds FROM sensors ORDER BY id";
			$result = $db->QueryDb($sql);
			while($row = $result->fetch_assoc()) {
				$Relay = trim($row['eid_relay']);
				$Target = trim($row['target']);
				$Status = trim($row['relay_status']);
				$Seconds = trim($row['relay_seconds']);
				if($Relay != $SensorStatus[$row['id']]["Relay"] || $Target != $SensorStatus[$row['id']]["Target"] || $Status != $SensorStatus[$row['id']]["Status"] || $Seconds != $SensorStatus[$row['id']]["Seconds"]) {
					$serial->sendMessage("1#".trim($row['id'])."#".$Relay."#".$Target."#".$Status."#".$Seconds."#@");
					$SensorStatus[$row['id']]["Relay"] = $Relay;
					$SensorStatus[$row['id']]["Target"] = $Target;
					$SensorStatus[$row['id']]["Status"] = $Status;
					$SensorStatus[$row['id']]["Seconds"] = $Seconds;
				}
			}
			
		}

		$serial->deviceClose();
		
	}

	$db->CloseDb();

?>