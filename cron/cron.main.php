<?php
	class cronMain{
		const ALLOWED = true;
		
		function run(){
			global $cronFig;
			
			$cronConnect = new cronConnect();
			$jobList = $cronConnect->fetchList(); // Fetch job-list
			
			// load all files
			// If link (file) cannot be found, report in log and set to inactive in database
			foreach($jobList as $job){
				if (!file_get_contents($job[$cronFig['mysql']['list_field_link']])){
					$linkStatus = 'UNABLE TO DEACTIVATE';
					if($cronConnect->deactivate($job[$cronFig['mysql']['list_field_ID']])){
						$linkStatus = 'INACTIVATED';
					}
					$cronConnect->cronLog("Missing File::{$job[$cronFig['mysql']['list_field_link']]}::{$linkStatus}");	
				}else{
					// File is found and loaded		
				}
			}
		}
	}
?>