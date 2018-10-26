<?php
	
	if(!($query = $con->prepare("SELECT * FROM leagues WHERE LeagueID = ?")))
		{
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		
		$query->bindValue(1, $_GET['leagueID'], PDO::PARAM_INT);
		$query->execute();
		
		$rowCount = $query->rowCount();
		
		if ($rowCount == 0)
		{
			echo "Error getting league<br>\n";
		}
		else
		{
			$row = $query->fetch();
			
			$leagueName = $row['LeagueName'];
			$moderator = $row['ModeratorID'];
			$leagueNote = $row['LeagueNote'];
			
		}

?>