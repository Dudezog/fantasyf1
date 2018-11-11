<?php

	//Initilize JSON array
	$response = array("Error" =>FALSE);
	
	if(!isset($_GET['id']) || !isset($_GET['driver1']) || !isset($_GET['driver2']))
	{
		$response["Error"] = TRUE;
		$response["ErrorMessage"] = "Parameters not passed.  Please pass track as 'id' & at least 2 drivers as 'driver1', 
		'driver2', 'driver3', 'driver4'";
	}
	else
	{
		$track = $_GET['id'];
		//Collect all of our drivers
		$drivers = array("Driver1" => $_GET['driver1'],
						 "Driver2" => $_GET['driver2']	
						);
		if(isset($_GET['driver3']))
		{
			$drivers["Driver3"] = $_GET['driver3'];
		}		
		if(isset($_GET['driver4']))
		{
			$drivers["Driver4"] = $_GET['driver4'];
		}	
		 
		
		$url = "http://localhost/f1/index_ugly.php?id=".$track;
		$json = file_get_contents(''.$url.'');
		$obj = json_decode($json);
		
		if(isset($obj->RaceInfo))
		{	
		
			//Copy over race info
			$response['RaceInfo'] = $obj->RaceInfo;	
			//Driver Info
			$response['Drivers'] = $drivers;		
			
			$points = 0;
		
			foreach($drivers as &$driver)
			{
				foreach($obj->Drivers as $item)
				{
					if($item->DriverNickName == $driver)
					{
						$points += $item->Points;
					}
				}
			}
			
			$response['Points'] = $points;
		}
		else
		{
			$response["Error"] = TRUE;
			$response["ErrorMessage"] = "Data not available for that race!";
		}

	}
	
	echo "<pre>";
	echo json_encode($response,  128 | 64);
	echo "</pre>";
	


?>