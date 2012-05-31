<?php
	// Configuration of Cron
	
	$cronFig = array(
		
		// Secret Setting
		'secret' => 'tlxHfBdw 4keJgsqr 64OIT9zB',
		
		// MySQL Settings
		'mysql' =>	array(
					'list_server' => 'localhost',
					'list_user' => 'root',
					'list_password' => 'jetta',
					'list_database' => 'cron_list',
					'list_table' => 'cron_files',
					'list_field_ID' => 'f_ID',
					'list_field_active' => 'f_active',
					'list_field_link' => 'f_link'
					),
					
		'log' =>	array(
					'name' => 'cron', // Name without extension, default: cron
					'directory' => ''
					)
		
				
	);
?>