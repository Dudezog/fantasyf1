<?php
	//Connect to database
	include('f1_db.inc.php');
	
	if(isset($_GET['raceid']))
	{
		$raceid = $_GET['raceid'];
			
		if(!($query = $con->prepare("SELECT picks.*, drivers.DriverID, drivers.DriverName FROM picks, 
		drivers WHERE picks.DriverID = drivers.DriverID AND picks.RaceNumber=?")))
			{
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			$query->bindValue(1, $raceid, PDO::PARAM_INT);
			$query->execute();
			
			$rowCount = $query->rowCount();
			
			if ($rowCount == 0)
			{
				echo "No Picks Made!";
			}
			else
			{
				$drivers = "";
				while($row = $query->fetch())
				{
					$drivers .= $row['DriverName']. " ";			
				}
				
				echo $drivers;	
			}	
		
	}

?>