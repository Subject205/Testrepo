<?php
	// Fetch Cron Configurations
	require('cron.config.php');
	
	// Make sure it's the correct "user"
	//if($_GET['secret'] != $cronFig['secret']){
		//die('Unauthorized Direct Access!');
	//}else{
		// Cron-Request is authorized, initiate main class
		require('cron.main.php');
		$cronMain = new cronMain();
		
		// Fetch connection-class
		require('cron.connect.php');
		$cronMain->run();
	//}
?>