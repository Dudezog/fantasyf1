<?php
	require_once('function_fix_kimi.php');
	
	//Initilize JSON array
	$response = array("Error" =>FALSE);

	//Build link
	//Note: No matter what race you click on the 'Fastest Lap' page from,
	//The table contains every race's results
	$myLink = "https://www.formula1.com/en/results.html/2019/fastest-laps/1000/australia/race-result.html";	
	
	//Initilize array for holding all of the lines of our webpage
	$lines = array();
	
	//Load url
	$handle = fopen($myLink, "r");
	if($handle)
	{
		//Save webpage into array
		while(($line = fgets($handle)) !== false)
		{
			/*
			*Don't need this
			* $line = str_replace("<", "&lt;", $line);
			* $line = str_replace(">", "&gt;", $line);
			*/
			
			//Get rid of html new line characters
			$line = str_replace("\r\n", "", $line);
			$line = trim($line);
			$lines[] = $line;
		}
		fclose($handle);
		
		//Look for this for start of race name
		$needle = "<td class=\"width30 dark\">";
		//Incrementer for keeping track of where we're at on the page
		$i = 0;	
		//Use a number code to keep track of races
		//This will match up with our race number parameters
		$raceID = 0;
		foreach($lines as &$myLine)
		{
			$myLine = trim($myLine);
			
			//Array for holding our race data
			$raceData = array();		
			
			//Grab Driver Data
			
			if(substr($myLine, 0, strlen($needle)) === $needle)
			{
				
				$driverName = $lines[$i + 2]." ".$lines[$i + 3];
				$driverName = fixKimi($driverName);
				
				$driverData = array(
					"RaceID" => $raceID,
					"Race" => strip_tags($myLine),
					"DriverName" => strip_tags($driverName),
					"DriverNickName" => strip_tags($lines[$i + 4]),
					"Constructor" => strip_tags($lines[$i + 6]),
					"Time" => strip_tags($lines[$i + 7])
				);
				$response["Result"][] = $driverData;
				
				$raceID++;
			}
			$i++;
		}
	
	}
	else
	{
		//Error opening file
		$response["Error"] = TRUE;
		$response["ErrorMessage"] = "Could not load URL.";
	}


	/*
	* NOTE:  <pre>, </pre> is for JSON PRETTY_PRINT. (Useful for humans to use) 
	* When implementing this for other programs to read, (IE Android Studio), it expects the file to start with '{' or '['
	*/
	//echo "<pre>";
	echo json_encode($response,  128 | 64);
	//echo "</pre>";

?>