<?php
	require_once('function_fix_kimi.php');
	//Initilize JSON array
	$response = array("Error" =>FALSE,
	"Total"=>0);
	//Count total records
	$count = 0;

	//Check parameter passed
	if(!isset($_GET['id']))
	{
		$response["Error"] = TRUE;
		$response["ErrorMessage"] = "Parameters not passed.  Pass the race number as 'id'";
	}
	//Do Work
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
		//All of our qualifiying pages
		$links = array(
			"https://www.formula1.com/en/results.html/2019/races/1000/australia/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1001/bahrain/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1002/china/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1003/azerbaijan/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1004/spain/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1005/monaco/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1006/canada/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1007/france/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1008/austria/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1009/great-britain/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1010/germany/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1011/hungary/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1012/belgium/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1013/italy/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1014/singapore/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1015/russia/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1016/japan/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1017/united-states/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1018/mexico/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1019/brazil/qualifying.html",
			"https://www.formula1.com/en/results.html/2019/races/1020/abu-dhabi/qualifying.html"
			);

		//Build link
		$myLink = $links[$choice];	
		
		//Array for holding all the lines from webpage
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
				
				//Get rid of HTML new line characters
				$line = str_replace("\r\n", "", $line);
				$line = trim($line);
				$lines[] = $line;
			}
			fclose($handle);
			
			//Look for this for start of race name
			$raceNeedle = "<h1 class=\"ResultsArchiveTitle\">";
			//Look for this for start of driver results info
			$driverNeedle = "<td class=\"dark\">";
			//Incrementer keeps track where we're at on page
			$i = 0;	
			foreach($lines as &$myLine)
			{
				$myLine = trim($myLine);
				
				//Arrays hold our data for JSON
				$raceData = array();		
				$driverData = array();
				
				//Grab race info data
				if(substr($myLine, 0, strlen($raceNeedle)) === $raceNeedle)
				{
					//strip_tags removes all HTML tags from line
					$raceData = array(
						"RaceName" => strip_tags($lines[$i+6]),
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
					$nickName = strip_tags($lines[$i + 5]);	

					$driverData = array(
						"Position" => strip_tags($myLine),
						"DriverNumber" => strip_tags($lines[$i + 1]),
						"DriverName" => strip_tags($driverName),
						"DriverNickName" => $nickName,
						"Constructor" => strip_tags($lines[$i + 7]),
						"Q1" => strip_tags($lines[$i + 9]),
						"Q2" => strip_tags($lines[$i + 10]),
						"Q3" => strip_tags($lines[$i + 11]),
						"Laps" => strip_tags($lines[$i + 14]),
						
					);
					$response["Result"][] = $driverData;
					$count++;				
				}
				$i++;
			}
			
			$response["Total"] = $count;
		
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