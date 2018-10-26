<?php

	if(isset($_COOKIE['userID']))
	{
		$userID = $_COOKIE['userID'];
		
		if(!($query = $con->prepare("SELECT leagues.*, memberships.* FROM leagues, memberships WHERE UserID = ? 
		AND leagues.LeagueID = memberships.LeagueID")))
		{
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		
		$query->bindValue(1, $userID, PDO::PARAM_INT);
		$query->execute();
		
		$rowCount = $query->rowCount();
		
		if ($rowCount == 0)
		{
			echo "You are not in any leagues!<br>\n";
		}
		else
		{
			//Multiple leagues, make user choose
			while($row = $query->fetch())
			{
				echo "<a href=\"index.php?content=league&leagueID=".$row['LeagueID']."\">".$row['LeagueName']."</a><br>";
			}
		}
	}
	else
	{
		include('login_fail.inc.php');
	}	

?>