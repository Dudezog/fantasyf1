<?php
	//Get LeagueName
	if(!($query = $con->prepare("SELECT LeagueName FROM leagues WHERE LeagueID = ?")))
	{
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
	
	$query->bindValue(1, $_GET['leagueID'], PDO::PARAM_INT);
	$query->execute();
	$row = $query->fetch();
	echo "<b>".$row['LeagueName']."</b>";
	
	echo "<p><h3>Standings</h3></p>\n";

	$year = date('Y');	
	
	require_once('race_date_functions.inc.php');	
	$currentRace = getRaceNum();

	//Get Standings	
	if(!($query = $con->prepare("SELECT picks.*,
								results.*, SUM(results.Total) AS 'Season Points',
								users.UserID, users.UserName
								FROM picks, results, users
								WHERE 
									picks.LeagueID = ? 
									AND picks.Season = ?
									AND picks.TrackID < ?									
									AND picks.DriverID = results.DriverID
									AND picks.TrackID = results.TrackID
									AND PICKS.Season = results.Season
									AND picks.UserID = users.UserID
								GROUP BY picks.UserID    
								ORDER BY 'Season Points' DESC")))
	{
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
	
	$query->bindValue(1, $_GET['leagueID'], PDO::PARAM_INT);
	$query->bindValue(2, $year, PDO::PARAM_INT);
	$query->bindValue(3, $currentRace, PDO::PARAM_INT);
	$query->execute();

	$rowCount = $query->rowCount();
	
	if ($rowCount == 0)
	{
		echo "No members in league!<br>\n";
	}
	else
	{
		
		//TO-DO:
		//Do this as a Table or DIVs so displays nicely
		
		while($row = $query->fetch())
		{
			echo $row['UserName'].": ".$row['Season Points']."<br>\n";
		}
				
			
	}


?>