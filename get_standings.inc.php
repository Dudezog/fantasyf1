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

	//TO-DO:  Get actual standings
	//For now, list all league members
	
	if(!($query = $con->prepare("SELECT users.UserID, users.UserName AS 'Name', memberships.UserID, memberships.LeagueID 
	FROM users, memberships WHERE LeagueID=? AND users.UserID = memberships.UserID")))
	{
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
	
	$query->bindValue(1, $_GET['leagueID'], PDO::PARAM_INT);
	$query->execute();
	
	$rowCount = $query->rowCount();
	
	if ($rowCount == 0)
	{
		echo "No members in league!<br>\n";
	}
	else
	{
		//Multiple leagues, make user choose
		while($row = $query->fetch())
		{
			echo $row['Name']."<br>";
		}
	}


?>