<?php
	
	if(isset($_POST['races']) && isset($_POST['driver1']) && isset($_POST['driver2']) && isset($_POST['userID']) && isset($_POST['leagueID'])
		&& isset($_POST['year']))
	{	

		$raceNum = $_POST['races'];
		$driver1 = $_POST['driver1'];
		$driver2 = $_POST['driver2'];
		$userID = $_POST['userID'];
		$league = $_POST['leagueID'];
		$year = $_POST['year'];
		
		require_once('race_date_functions.inc.php');	
		$currentRace = getRaceNum();
		
		//Check race date deadline hasn't passed
		$isValidPick = isValidPick($raceNum);

		if($isValidPick)
		{
			$badUser = false;
			
			//Obvious: Drivers cannot equal
			if($driver1 == $driver2)
			{
				$badUser = true;
				echo "Driver Picks must be different";
			}
			
			//Check if we already used these drivers
			//Get range of races based off this race pick
			$range1 = null;
			$range2 = null;
			if($raceNum <= 9)
			{
				$range1 = 0;
				$range2 = 9;
			}
			elseif($raceNum >= 10 && $raceNum <= 19)
			{
				$range1 = 10;
				$range2 = 19;
			}
			else
			{
				$range1 = 20;
				$range2 = 20;
			}
			
			if(!($query = $con->prepare("SELECT picks.*, drivers.DriverID, drivers.DriverName, tracks.TrackID, tracks.RaceName 
			FROM picks, drivers, tracks 
			WHERE picks.UserID = ? 
			AND picks.LeagueID = ? 
			AND (picks.DriverID = ?  OR picks.DriverID = ?) 
			AND picks.season = ? 
			AND (picks.TrackID >= ? AND picks.TrackID <= ?) 
			AND picks.DriverID = drivers.DriverID 
			AND picks.TrackID = tracks.TrackID")))
			{
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			$query->bindValue(1, $userID, PDO::PARAM_INT);
			$query->bindValue(2, $league, PDO::PARAM_INT);
			$query->bindValue(3, $driver1, PDO::PARAM_INT);
			$query->bindValue(4, $driver2, PDO::PARAM_INT);
			$query->bindValue(5, $year, PDO::PARAM_INT);
			$query->bindValue(6, $range1, PDO::PARAM_INT);
			$query->bindValue(7, $range2, PDO::PARAM_INT);
			$query->execute();
			
			$rowCount = $query->rowCount();
			
			if ($rowCount != 0)
			{					
				while($row = $query->fetch())
				{
					//If we are editing a pick before the race started, it is a valid edit
					if($raceNum != $row['TrackID'])
					{
						$badUser = true;
						echo "Sorry you have picked that driver before:<br>\n";
						echo $row['DriverName']." at ".$row['RaceName']."<br>\n";	
					}			
				}
				
				if($badUser)
				{
					echo "<a href=\"index.php?content=team&leagueID=".$league."&teamID=".$userID."\">Please Try Again</a><br>\n";
				}
			}		
			
			if(!$badUser)
			{
				//Get Picks ID
				if(!($query = $con->prepare("SELECT PickID FROM picks 
				WHERE UserID = ? 
				AND LeagueID = ? 
				AND Season = ? 
				AND TrackID = ?")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
				$query->bindValue(1, $userID, PDO::PARAM_INT);
				$query->bindValue(2, $league, PDO::PARAM_INT);
				$query->bindValue(3, $year, PDO::PARAM_INT);
				$query->bindValue(4, $raceNum, PDO::PARAM_INT);
				$query->execute();
				
				$rowCount = $query->rowCount();				
				
				if($rowCount == 2)
				{
					$picks = array();
					$i = 0;
					while($row = $query->fetch())
					{
						$picks[$i] = $row['PickID'];
						$i++;
					}
				}
				else
				{
					$badUser = true;
				}
				
				if(!$badUser)
				{
					
					if(!($query2 = $con->prepare("UPDATE picks SET DriverID = ? WHERE PickID = ?")))
					{
						echo "Prepare failed: (" . $con->errno . ") " . $con->error;
					}

					//Driver 1
					$query2->bindValue(1, $driver1, PDO::PARAM_INT);
					$query2->bindValue(2, $picks[0], PDO::PARAM_INT);
					$resultDriver1 = $query2->execute();
					
					//Driver 2
					$query2->bindValue(1, $driver2, PDO::PARAM_INT);
					$query2->bindValue(2, $picks[1], PDO::PARAM_INT);
					$resultDrier2 = $query2->execute();
					
					if($resultDriver1 && $resultDrier2)
					{
						echo "Driver picks made!<br>\n";
						echo "<a href=\"index.php?content=team&leagueID=".$league."&teamID=".$userID."\">My Team</a><br>\n";
						
					}
					else
					{
						echo "An Error occurred adding picks.  Please try again.";
					}				
				}	
			}
			
		}
		else
		{
			echo "<p>Sorry, Deadline for picking that race has passed!</p>\n";
		}
	}
	else
	{
		echo "<p>An error occured.  Please try again.</p>\n";
	}


?>