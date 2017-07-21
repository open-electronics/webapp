<?php

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
	

	if($Command == "shutdown") {
		system("sudo /sbin/shutdown -h now");
	}
	
	
?>