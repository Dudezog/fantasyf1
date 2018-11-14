<h3>Results</h3>

<?php

	require_once('race_date_functions.inc.php');	
	$currentRace = getRaceNum();

	//Get Race name
	if(!($query = $con->prepare("SELECT RaceName from tracks WHERE TrackID = ?")))
	{
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
	
	$query->bindValue(1, $currentRace, PDO::PARAM_INT);
	$query->execute();

	$row = $query->fetch();
	echo "<h3>".$row['RaceName']."</h3><br>\n";
	
	
	//Get Results from last race
	if(!($query = $con->prepare("SELECT results.DriverID, results.Total, 
		drivers.DriverID, drivers.DriverName, 
		FROM results, drivers
		WHERE results.TrackID = ? 
		AND drivers.DriverID > 0 
		AND drivers.DriverID = results.DriverID 
		ORDER BY Total DESC")))
	{
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
	
	$query->bindValue(1, $currentRace, PDO::PARAM_INT);
	$query->execute();

	$rowCount = $query->rowCount();
	
	if ($rowCount == 0)
	{
		echo "Sorry!  Results are not in yet!<br>\n";
	}
	else
	{
		
		//TO-DO:
		//Do this as a Table or DIVs so displays nicely		
		while($row = $query->fetch())
		{
			echo $row['DriverName'].": ".$row['Total']."<br>\n";
		}				
			
	}


?>