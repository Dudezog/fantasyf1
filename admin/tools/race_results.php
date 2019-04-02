<?php

	require_once('function_fix_kimi.php');
	//Initilze JSON array	
	$response = array("Error" =>FALSE);
	//Count total records
	$count = 0;
	
	//Check parameters passed
	if(!isset($_GET['id']))
	{
		$response["Error"] = TRUE;
		$response["ErrorMessage"] = "Parameters not passed.  Pass the race number as 'id'";
	}
	//Let's do a bunch of stuff
	else
	{
		$choice = $_GET['id'];

		//Make sure id isn't out of bounds
		if($choice < 0){
			$choice = 0;
		}
		if($choice > 20){
			$choice = 20;
		}

		

		
		//All race links
		$links = array(
			"https://www.formula1.com/en/results.html/2019/races/1000/australia/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1001/bahrain/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1002/china/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1003/azerbaijan/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1004/spain/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1005/monaco/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1006/canada/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1007/france/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1008/austria/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1009/great-britain/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1010/germany/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1011/hungary/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1012/belgium/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1013/italy/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1014/singapore/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1015/russia/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1016/japan/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1017/united-states/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1018/mexico/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1019/brazil/race-result.html",
			"https://www.formula1.com/en/results.html/2019/races/1020/abu-dhabi/race-result.html"
			);

		//Build link
		$myLink = $links[$choice];	
		
		//Array for holding all lines of webpage
		$lines = array();
		
		//Load url
		$handle = fopen($myLink, "r");
		if($handle)
		{
			while(($line = fgets($handle)) !== false)
			{
				/*
				*Don't need this
				 $line = str_replace("<", "&lt;", $line);
				 $line = str_replace(">", "&gt;", $line);
				*/
				
				//Get rid of html new line characters
				$line = str_replace("\r\n", "", $line);
				$line = trim($line);
				$lines[] = $line;
			}
			fclose($handle);
			
			//Look for this for start of race name
			$raceNeedle = "<h1 class=\"ResultsArchiveTitle\">";
			//Look for this for start of driver results info
			$driverNeedle = "<td class=\"dark\">";
			//Incrementer to keep track where we're at on page
			$i = 0;	
			
			foreach($lines as &$myLine)
			{
				$myLine = trim($myLine);
				//Arrays for holding our race data
				$raceData = array();		
				$driverData = array();
				
				//Grab race info data
				//strip_tags removes all HTML tags from line
				if(substr($myLine, 0, strlen($raceNeedle)) === $raceNeedle)
				{
					$raceData = array(
						"RaceName" => strip_tags($lines[$i + 6]),
						"Date" => strip_tags($lines[$i + 31])." - ".strip_tags($lines[$i + 33]),
						"Track" => strip_tags($lines[$i + 34])
					);
					$response["Race"][] = $raceData;
				}
				
				//Grab Driver Data
				if(substr($myLine, 0, strlen($driverNeedle)) === $driverNeedle)
				{
					
					$driverName = $lines[$i + 3]." ".$lines[$i + 4];
					$driverName = fixKimi($driverName);
					
					$driverData = array(
						"Position" => strip_tags($myLine),
						"DriverNumber" => strip_tags($lines[$i + 1]),
						"DriverName" => strip_tags($driverName),
						"DriverNickName" => strip_tags($lines[$i + 5]),
						"Constructor" => strip_tags($lines[$i + 7]),
						"Laps" => strip_tags($lines[$i + 8]),
						"Time" => strip_tags($lines[$i + 9]),
						"Points" => strip_tags($lines[$i + 10])
					);
					$response["Result"][] = $driverData;
					$count++;
				}
				$i++;
			}
			
			$response["Count"] = $count;
		
		}
		else
		{
			//Error opening file
			$response["Error"] = TRUE;
			$response["ErrorMessage"] = "Could not load URL.";
		}

	}

	/*
	* NOTE:  <pre>, </pre> is for JSON PRETTY_PRINT. (Useful for humans to use) 
	* When implementing this for other programs to read, (IE Android Studio), it expects the file to start with '{' or '['
	*/
	//echo "<pre>";
	echo json_encode($response,  128 | 64);
	//echo "</pre>";

?>