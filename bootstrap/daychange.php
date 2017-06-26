<?php
		session_start();
		$_SESSION['nowdate']  = strtotime($_REQUEST['daychange']);
		header('location: confirmation.php');

?>