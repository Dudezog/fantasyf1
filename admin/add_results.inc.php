<?php

    if(isset($_POST['race']))
	{
		$raceNum = $_POST['race'];
		$year = date("Y");

		// Check if results already in table
		if(!($query = $con->prepare("SELECT * FROM results WHERE TrackID = ? AND Season = ?")))
		{
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		$query->bindValue(1, $raceNum, PDO::PARAM_INT);
		$query->bindValue(2, $year, PDO::PARAM_STR);
		$query->execute();
		
		$rowCount = $query->rowCount();
		
		if($rowCount != 0)
		{
			while($row = $query->fetch())
			{
				//////////////////////////////////
				echo "Results ID:  ".$row['ResultID']."<br>";
				/////////////////////////////////////
				
				//Remove previous results
				if(!($query2 = $con->prepare("DELETE FROM results WHERE ResultID = ?")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
				$query2->bindValue(1, $row['ResultID'], PDO::PARAM_INT);
				//$query2->execute();
				
			}
		}
		
		//Get Race Results
		$url = "http://www.bridgerest.com/fantasyf1/admin/tools/index.php?id=".$raceNum;
		$json = file_get_contents(''.$url.'');
		$obj = json_decode($json);
		
		if(!$obj->Error)
		{
			foreach($obj->Drivers as $item)
			{
				$driverID = getDriverID($item->DriverName);
				$qualifyingPoints = $item->Points[0]->QualifyingPoints;
				$fastLapPoints = $item->Points[0]->FastLap;
				$posChangePoints = $item->Points[0]->PositionChange;
				$resultPoints = $item->Points[0]->Result;
				$total = $item->Points[0]->Total;
			
				echo "<p>race num: ".$raceNum;
				echo "<p>driver: ".$driverID;
				echo "<p>qualifying: ".$qualifyingPoints;
				echo "<p>fast lap: ".$fastLapPoints;
				echo "<p>pos change: ".$posChangePoints;
				echo "<p>result: ".$resultPoints;
				echo "<p>Total: ".$total;
				echo "<p>Season: ".$year."<br><br>";
				
			
				//Insert Race Results
				if(!($query3 = $con->prepare("INSERT INTO results (TrackID, DriverID, QualifyingPoints, FastLapPoints, PositionChangePoints, 
				RaceFinishPoints, Total, Season) VALUES(?, ?, ?, ?, ?, ?, ?, ?)")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
				$query3->bindValue(1, $raceNum, PDO::PARAM_INT);
				$query3->bindValue(2, $driverID, PDO::PARAM_INT);
				$query3->bindValue(3, $qualifyingPoints, PDO::PARAM_INT);
				$query3->bindValue(4, $fastLapPoints, PDO::PARAM_INT);
				$query3->bindValue(5, $posChangePoints, PDO::PARAM_INT);
				$query3->bindValue(6, $resultPoints, PDO::PARAM_INT);
				$query3->bindValue(7, $total, PDO::PARAM_INT);
				$query3->bindValue(8, $year, PDO::PARAM_STR);
				
				$result3 = $query3->execute();
				
				if($result3)
				{
					echo "Results Inserted";
				}
				else
				{
					echo "Error inserting result";
				}
	
				
			}
			
		}
		
		
	}
	else
	{
		echo "An error occurred.  Parameters not correctly passed.";
	}
		
		
	function getDriverID($driverName)
	{
		$driverID = 0;
		switch($driverName)
		{
			case "Lewis Hamilton": $driverID = 1;
			break;
			
			case "Sebastian Vettel": $driverID = 2;
			break;
			
			case "Daniel Ricciardo": $driverID = 3;
			break;
			
			case "Kimi Raikkonen": $driverID = 4;
			break;
			
			case "Valtteri Bottas": $driverID = 5;
			break;
			
			case "Max Verstappen": $driverID = 6;
			break;
			
			case "Sergio Perez": $driverID = 7;
			break;
			
			case "Esteban Ocon": $driverID = 8;
			break;
			
			case "Fernando Alonso": $driverID = 9;
			break;
			
			case "Kevin Magnussen": $driverID = 10;
			break;
			
			case "Romain Grosjean": $driverID = 11;
			break;
			
			case "Stoffel Vandoorne": $driverID = 12;
			break;
			
			case "Nico Hulkenberg": $driverID = 13;
			break;
			
			case "Carlos Sainz": $driverID = 14;
			break;
			
			case "Marcus Ericsson": $driverID = 15;
			break;
			
			case "Brendon Hartley": $driverID = 16;
			break;
			
			case "Sergey Sirotkin": $driverID = 17;
			break;
			
			case "Lance Stroll": $driverID = 18; 
			break;
			
			case "Pierre Gasly": $driverID = 19;
			break;
			
			case "Charles Leclerc": $driverID = 20;
			break;
			
			case "Lando Norris": $driverID = 21;
			break;
			
			case "Antonio Giovinazzi": $driverID = 22;
			break;
			
			case "Daniil Kvyat": $driverID = 23;
			break;
			
			case "Alexander Albon": $driverID = 24;
			break;
			
			case "Robert Kubica": $driverID = 25;
			break;
			
			case "George Russell": $driverID = 26;
			break;
			
		}


		return $driverID;

	}	

?>