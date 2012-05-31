<?php
	// If loaded by authorized file
	if(!$cronMain::ALLOWED){
		die('Direct access not allowed!');
	}
	
class cronConnect{
		var $connection;
	
		// function to kill cron & write to log-file
		function cronLog($message = 'No error-message provided', $kill = false){
			global $cronFig;
			
			$logFile = fopen($cronFig['log']['directory'].$cronFig['log']['name'].'.log', 'a') or die('cannot open file!');
			$entry = "[".date("d/M/Y:H:i:s O")."] ".$message."\r\n";
			fwrite($logFile, $entry);
			fclose($logFile);
			if($kill){ 
				die();
			}
		}
	
		// Connect to Cron-list
		function fetchList(){
			global $cronFig;
			
			$error = false;
			$connection = mysql_connect($cronFig['mysql']['list_server'], $cronFig['mysql']['list_user'], $cronFig['mysql']['list_password']) or $error = array('type' => 'Connection Setting Error.');
			if(!is_array($error) && mysql_ping($connection)){
				mysql_select_db($cronFig['mysql']['list_database'], $connection) or $error = array('type' => 'Database Error.');
				if(!is_array($error) && mysql_ping($connection)){ 
					if(!$query = mysql_query("SELECT * FROM {$cronFig['mysql']['list_table']} WHERE {$cronFig['mysql']['list_field_active']} = 1", $connection)){						
						if(!mysql_ping($connection)){
							$error = array('type' => 'Lost connection to Server.');
						}else{
							$error = array('type' => 'Query Error: ');
						}
					}
				}else if(!mysql_ping($connection)){
					$error = array('type' => 'Lost connection to server.');
				}
			}else if(!mysql_ping($connection)){
				$error = array('type' => 'Connection Setting Error.');
			}
			if(is_array($error)){
						$this->cronLog($error['type'], true);	// Kill on Error
			}
			// No error so far, return fetched data in array-form
			$list = array();
			while($file = mysql_fetch_assoc($query)){
				array_push($list, $file);
			}
			return $list;
		}
		
		// Function for deactivating a broken link
		function deactivate($linkID){
			global $cronFig;
			
			$error = false;
			$deactivated = true;
			if(isset($linkID)){
				$connection = mysql_connect($cronFig['mysql']['list_server'], $cronFig['mysql']['list_user'], $cronFig['mysql']['list_password']) or $error = array('type' => 'Connection Setting Error.');
				if(!is_array($error) && mysql_ping($connection)){
					mysql_select_db($cronFig['mysql']['list_database'], $connection) or $error = array('type' => 'Database Error.');
					if(!is_array($error) && mysql_ping($connection)){ 
						if(!$query = mysql_query("UPDATE {$cronFig['mysql']['list_table']} SET {$cronFig['mysql']['list_field_active']} = 0 WHERE {$cronFig['mysql']['list_field_ID']} = {$linkID}", $connection)){						
							if(!mysql_ping($connection)){
								$error = array('type' => 'Lost connection to Server.');
							}else{
								$error = array('type' => 'Query Error: ');
							}
						}
					}else if(!mysql_ping($connection)){
						$error = array('type' => 'Lost connection to server.');
					}
				}else if(!mysql_ping($connection)){
					$error = array('type' => 'Connection Setting Error.');
				}
			}else{
				$error = array('type' => 'No Link ID provided.');
			}
			if(is_array($error)){
						$this->cronLog('Deactivate: '.$error['type']);	// Report Errors
						$deactivated = false;
			}
			return $deactivated;
		}	
	}
?>