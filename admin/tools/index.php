<?php	
	//Initilize JSON array
	$response = array("Error" =>FALSE);
	
	//Check parameters passed
	if(!isset($_GET['id']))
	{
		$response["Error"] = TRUE;
		$response["ErrorMessage"] = "Parameters not passed.  Pass the race number as 'id'";
		
		$tracks = array('0 - Australia',
						'1 - Bahrain',
						'2 - China',
						'3 - Azerbaijan',
						'4 - Spain',
						'5 - Monaco',
						'6 - Canada',
						'7 - France',
						'8 - Austria',
						'9 - Great Britain',
						'10 - Germany',
						'11 - Hungary',
						'12 - Belgium',
						'13 - Italy',
						'14 - Singapore',
						'15 - Russia',
						'16 - Japan',
						'17 - United States',
						'18 - Mexico',
						'19 - Brazil',
						'20 - Abu Dhabi'						
				);
		
		$response["TrackIDs"][] = $tracks;
	}
	//Have a parameter, get to work
	else
	{
		$choice = $_GET['id'];
		//Check parameter is within range
		if($choice < 0){
			$choice = 0;
		}
		if($choice > 20){
			$choice = 20;
		}
		
		//All of our drivers in an array
		$drivers = array( 'HAM',
						  'BOT',
						  'VET',
						  'RAI',
						  'RIC',
						  'VER',
						  'LEC',
						  'ERI',
						  'MAG',
						  'GRO',
						  'OCO',
						  'PER',
						  'HUL',
						  'SAI',
						  'ALO',
						  'VAN',
						  'SIR',
						  'STR',
						  'GAS',
						  'HAR'
						  
						);
		//Qualifying
		$urlQualifying = "http://localhost/f1/qualifying_results.php?id=".$choice;
		$jsonQualifying = file_get_contents(''.$urlQualifying.'');
		$objQualifying = json_decode($jsonQualifying);
	
		
		$urlGrid = "http://localhost/f1/grid_pos.php?id=".$choice;
		$jsonGrid = file_get_contents(''.$urlGrid.'');
		$objGrid = json_decode($jsonGrid);
		
		$urlResults = "http://localhost/f1/race_results.php?id=".$choice;
		$jsonResults = file_get_contents(''.$urlResults.'');
		$objResults = json_decode($jsonResults);
		
		$urlFastLap = "http://localhost/f1/fastest_lap.php?id=".$choice;
		$jsonFastLap = file_get_contents(''.$urlFastLap.'');
		$objFastLap = json_decode($jsonFastLap);
		
		//Check all of our objects set
		if(isset($objQualifying->Result) && isset($objGrid->Result) && isset($objResults->Result ) && isset($objFastLap->Result))
		{
			
					//Push Race Data into array
			$data = array("RaceName" => $objQualifying->Race[0]->RaceName,
					  "Date" => $objQualifying->Race[0]->Date,
					  "Track" => $objQualifying->Race[0]->Track
					);
			$response["RaceInfo"][] = $data;	
		
		
			//Figure Scores
			foreach($drivers as &$driver)
			{
				$qualifyingPos = -1;
				$startingPos = -1;
				$finishPos = -1;
				$isFastLap = false;
				$data = array();
				
				//Qualifying
				foreach($objQualifying->Result as $item)
				{
					if($item->DriverNickName == $driver)
					{
						$qualifyingPos = $item->Position;
					}
				}
				//Starting grid
				foreach($objGrid->Result as $item)
				{
					if($item->DriverNickName == $driver)
					{
						$startingPos = $item->GridPosition;
					}
				}
				//Finish
				foreach($objResults->Result as $item)
				{
					if($item->DriverNickName == $driver)
					{
						$finishPos = $item->Position;
						
						//Grab all of our driver info while we're here
						$data["DriverName"] = $item->DriverName; 
						$data["DriverNickName"] = $item->DriverNickName;
						$data["DriverNumber"] = $item->DriverNumber;
						$data["Constructor"] = $item->Constructor;
					}
				}
				//Fast Lap
				foreach($objFastLap->Result as $item)
				{
					if($item->RaceID == $choice)
					{
						if($objFastLap->Result[$choice]->DriverNickName == $driver)
						{
							$isFastLap = true;
						}
					}
				}
				
				$data["QualifyingPos"] = $qualifyingPos;
				$data["StartingGrid"] = $startingPos;
				$data["RaceResult"] = $finishPos;
				$data["IsFastLap"] = $isFastLap;
				
				$data["Points"][] = getPoints($qualifyingPos, $startingPos, $finishPos, $isFastLap);
				
				$response["Drivers"][] = $data;
				
			}	
		}		
		else
		{
			$response["Error"] = TRUE;
			$response["ErrorMessage"] = "Data not available for that race!";
		}
		
	}
	
	//Pretty print so Humans can read the results
	//echo "<pre>";
	echo json_encode($response,  128 | 64);
	//echo "</pre>";


	
	function getPoints($qualifyingPos, $startPos, $finishPos, $isFastLap)
	{
		$data = array("Total" => 0);
		$points = 0;		
		
		//5 pts for pole
		if($qualifyingPos == 1)
		{
			$points += 5;
			$data['QualifyingPoints'] = 5;
		}
		else
		{
			$data['QualifyingPoints'] = 0;
		}
		
		if($finishPos == "NC" || $finishPos == "DQ")
		{
			$points -= 15;
			$data['PositionChange'] = -15;
			$data['Result'] = 0;
		}
		else
		{
			//If Grid Pos is still -1, Driver is starting from pit lane
			//No passing bonus available
			
			//Passing Points
			if($startPos != -1)
			{
				$posPoints = (($startPos - $finishPos)* 2);
				$points += $posPoints;
				$data['PositionChange'] = $posPoints;
			}
			else
			{
				$data['PositionChange'] = 0;
			}	
			
			$finishPoints = 0;
			//Final Race Finish Points
			switch($finishPos)
			{			
				
				case 1: $finishPoints = 50;
				break;
				
				case 2: $finishPoints =  38;
				break;
				
				case 3: $finishPoints =  30;
				break;
				
				case 4: $finishPoints = 24;
				break;
				
				case 5: $finishPoints =  20;
				break;
				
				case 6: $finishPoints =  16;
				break;
				
				case 7: $finishPoints =  14;
				break;
				
				case 8: $finishPoints =  12;
				break;
				
				case 9:
				case 10: $finishPoints =  10;
				break;
				
				case 11:
				case 12: $finishPoints =  8;
				break;
				
				case 13:
				case 14: $finishPoints =  6;
				break;
				
				case 15:
				case 16: $finishPoints =  4;
				break;
				
				case 17:
				case 18: $finishPoints =  2;
				break;
				
				case 19:
				case 20: $finishPoints =  1;
				break;			
				
			}	
				$points += $finishPoints;
				$data['Result'] = $finishPoints;			
		}

		//If we have fast lap, 2 pts
		if($isFastLap)
		{
			$points += 2;
			$data['FastLap'] = 2;			
		}
		else
		{
			$data['FastLap'] = 0;
		}
		
		$data['Total'] = $points;
		
		return $data;
	}

?>