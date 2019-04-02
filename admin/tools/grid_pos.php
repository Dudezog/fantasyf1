<?php
	require_once('function_fix_kimi.php');
	
	//Initilize JSON array
	$response = array("Error" =>FALSE);
	//Count total driver records
	$count = 0;
	
	//Check parameter was passed
	if(!isset($_GET['id']))
	{
		$response["Error"] = TRUE;
		$response["ErrorMessage"] = "Parameters not passed.  Pass the race number as 'id'";
	}
	//Time to get to work
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
			
		//All of the starting grid links
		$links = array(
			"https://www.formula1.com/en/results.html/2019/races/1000/australia/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1001/bahrain/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1002/china/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1003/azerbaijan/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1004/spain/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1005/monaco/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1006/canada/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1007/france/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1008/austria/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1009/great-britain/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1010/germany/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1011/hungary/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1012/belgium/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1013/italy/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1014/singapore/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1015/russia/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1016/japan/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1017/united-states/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1018/mexico/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1019/brazil/starting-grid.html",
			"https://www.formula1.com/en/results.html/2019/races/1020/abu-dhabi/starting-grid.html"
			);

		//Build link
		$myLink = $links[$choice];	
		
		//Initilize array for holding all of the lines of our webpage
		$lines = array();
		
		//Load url
		$handle = fopen($myLink, "r");
		
		//Save webpage into array
		if($handle)
		{
			while(($line = fgets($handle)) !== false)
			{
				
				/*
				 *Don't need to do this
					
				  $line = str_replace("<", "&lt;", $line);
				  $line = str_replace(">", "&gt;", $line);
				*/
				
				//Get rid of html new line characters
				$line = str_replace("\r\n", "", $line);
				$line = trim($line);
				$lines[] = $line;
			}
			fclose($handle);
			
			//This is the unique code at the start of every race info listing
			$raceNeedle = "<h1 class=\"ResultsArchiveTitle\">";
			//Start of every driver info listing
			$driverNeedle = "<span class=\"first-name hide-for-tablet\">";
			
			//Incrementer to save where we're at on the webpage
			$i = 0;	
			foreach($lines as &$myLine)
			{
				$myLine = trim($myLine);
				
				//Arrays to hold the data we want for our JSON
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
					
					$driverName = $myLine." ".$lines[$i + 1];
					$driverName = fixKimi($driverName);
					
					$driverData = array(
						"GridPosition" => strip_tags($lines[$i-3]),
						"DriverNumber" => strip_tags($lines[$i - 2]),
						"DriverName" => strip_tags($driverName),
						"DriverNickName" => strip_tags($lines[$i + 2]),
						"Constructor" => strip_tags($lines[$i + 4]),
						"Q3Time" => strip_tags($lines[$i + 5])

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