<?php
	
	if(isset($_POST["leagueID"]))
	{
		$leagueID = $_POST['leagueID'];
		
		//Remove all League Picks
		if(!($query1 = $con->prepare("DELETE FROM picks WHERE LeagueID = ?")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
			   $query1->bindValue(1, $leagueID, PDO::PARAM_INT);		   
			   
			   $result1 = $query1->execute();
			   
		//Remove Champions
		if(!($query2 = $con->prepare("DELETE FROM champions WHERE LeagueID = ?")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
			   $query2->bindValue(1, $leagueID, PDO::PARAM_INT);		   
			   
			   $result2 = $query2->execute();	

		//Delete League memberships
		if(!($query3 = $con->prepare("DELETE FROM memberships WHERE LeagueID = ?")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
			   $query3->bindValue(1, $leagueID, PDO::PARAM_INT);		   
			   
			   $result3 = $query3->execute();	
		
		//Delete League
		if(!($query4 = $con->prepare("DELETE FROM leagues WHERE LeagueID = ?")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
			   $query4->bindValue(1, $leagueID, PDO::PARAM_INT);		   
			   
			   $result4 = $query4->execute();
			   
		if($result1 && $result2 && $result3 && $result4)
		{
			echo "<p>League Deleted</p>\n";
			echo "<script> location.replace(\"index.php?content=my_leagues\"); </script>";
		}	
		else
		{
			echo "<p>Error deleting league</p>\n";
		}
		
	}
	else
	{
		echo "Error deleting league.  Correct Parameters not passed.\n";
	}

?>