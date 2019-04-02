<?php
	
	if(!($query = $con->prepare("SELECT users.UserID, users.UserName, memberships.UserID 
	FROM users, memberships 
	WHERE memberships.LeagueID = ? AND users.UserID = memberships.UserID")))
		{
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		
		$query->bindValue(1, $_GET['leagueID'], PDO::PARAM_INT);
		$query->execute();
		
		$rowCount = $query->rowCount();
		
		if ($rowCount == 0)
		{
			echo "Error getting league members<br>\n";
		}
		else
		{
			while($row = $query->fetch())
			{
				echo "<a href=\"index.php?content=userprofile&userID=".$row['UserID']."&leagueID=".$_GET['leagueID']."\">".$row['UserName']."</a><br>";
			}
			
		}

?>