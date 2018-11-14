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
		
		//All of our driver IDs in an array
		$drivers = array( 
		array(1,'HAM'),
		array(5,'BOT'),
		array(2,'VET'),
		array(4,'RAI'),
		array(3,'RIC'),
		array(6,'VER'),
		array(20,'LEC'),
		array(15,'ERI'),
		array(10,'MAG'),
		array(11,'GRO'),
		array(8,'OCO'),
		array(7,'PER'),
		array(13,'HUL'),
		array(14,'SAI'),
		array(9,'ALO'),
		array(12,'VAN'),
		array(17,'SIR'),
		array(18,'STR'),
		array(19,'GAS'),
		array(16,'HAR')	
		);	
		
		//Qualifying
		//One Qualifying Winner gets 5pts
		$qualifying = array(5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		
		//Starting Grid
		$startingGrid = array();
		
		for($x = 1; $x <=20; $x++)
		{
			$startingGrid[$x-1] = $x;
		}	

		//Results
		$results = array(
		array(1,50),
		array(2,38),
		array(3,30),
		array(4,24),
		array(5,20),
		array(6,16),
		array(7,14),
		array(8,12),
		array(9,10),
		array(10,10),
		array(11,8),
		array(12,8),
		array(13,6),
		array(14,6),
		array(15,4),
		array(16,4),
		array(17,2),
		array(18,2),
		array(19,1),
		array(20,1)
		);		
		
		//Fast Lap
		//One winner gets 2pts
		$fastLap = array(2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
			
		//Push Race Data into array
		date_default_timezone_set("America/Chicago");
			$data = array("RaceName" => "Test Race",
					  "Date" => date("Y-m-d h:m:s"),
					  "Track" => "Test Track",
					  "RaceNum" =>$choice
					);
			$response["RaceInfo"][] = $data;	
		
		//Randomize results
		shuffle($qualifying);
		shuffle($startingGrid);
		shuffle($results);
		shuffle($fastLap);
		
		for($i = 0; $i < 20; $i++)
		{
			$posChange = (($startingGrid[$i] - $results[$i][0]) * 2);
			$total = $qualifying[$i] + $fastLap[$i] + $posChange + $results[$i][1];
			
			$data = array("DriverID" =>$drivers[$i][0],
						  "DriverName" => $drivers[$i][1],	
						  "Qualifying" =>$qualifying[$i],
						  "Starting Grid" => $startingGrid[$i],
						  "Finish Pos" => $results[$i][0],
						  "FastLap" => $fastLap[$i],
						  "PosChange" => $posChange,
						  "ResultPoints" => $results[$i][1],
						  "Total" => $total
						  
						 );
			$response["results"][] = $data;			 
		}		
		
			
	}
		
		
	//Pretty print so Humans can read the results
	echo "<pre>";
	echo json_encode($response,  128 | 64);
	echo "</pre>";

?>