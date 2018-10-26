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
			if($raceNum <= 10)
			{
				$range1 = 0;
				$range2 = 10;
			}
			elseif($raceNum >= 11 && $raceNum <= 20)
			{
				$range1 = 11;
				$range2 = 20;
			}
			else
			{
				$range1 = 21;
				$range2 = 21;
			}
			
			if(!($query = $con->prepare("SELECT picks.*, drivers.DriverID, drivers.DriverName, tracks.RaceNumber, tracks.RaceName 
			FROM picks, drivers, tracks 
			WHERE picks.UserID = ? 
			AND picks.LeagueID = ? 
			AND (picks.DriverID = ?  OR picks.DriverID = ?) 
			AND picks.season = ? 
			AND (picks.RaceNumber >= ? AND picks.RaceNumber <= ?) 
			AND picks.DriverID = drivers.DriverID 
			AND picks.RaceNumber = tracks.RaceNumber")))
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
					//If we used this driver on current race week,
					//IE-- we're changing our picks, this is a valid pick
					if($row['RaceNumber'] >= $currentRace)
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
				
			
			
			//Check if we already made picks & need update previous picks
			if(!($query2 = $con->prepare("SELECT * FROM picks 
			WHERE UserID = ? 
			AND LeagueID = ? 
			AND Season = ? 
			AND RaceNumber = ?")))
			{
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			$query2->bindValue(1, $userID, PDO::PARAM_INT);
			$query2->bindValue(2, $league, PDO::PARAM_INT);
			$query2->bindValue(3, $year, PDO::PARAM_INT);
			$query2->bindValue(4, $raceNum, PDO::PARAM_INT);
			$query2->execute();
			
			$rowCount2 = $query2->rowCount();
			
			if ($rowCount2 != 0)
			{
				while($row2 = $query2->fetch())
				{
					//Check if we already made picks & need update previous picks
					if(!($query3 = $con->prepare("DELETE FROM picks WHERE PickID = ?")))
					{
						echo "Prepare failed: (" . $con->errno . ") " . $con->error;
					}
					$query3->bindValue(1, $row2['PickID'], PDO::PARAM_INT);
					$query3->execute();
				}
			}
			
			if(!$badUser)
			{
					if(!($query4 = $con->prepare("INSERT INTO picks (UserID, LeagueID, RaceNumber, DriverID, Season) 
						VALUES(?, ?, ?, ?, ?)")))
					{
						echo "Prepare failed: (" . $con->errno . ") " . $con->error;
					}
					$query4->bindValue(1, $userID, PDO::PARAM_INT);
					$query4->bindValue(2, $league, PDO::PARAM_INT);
					$query4->bindValue(3, $raceNum, PDO::PARAM_INT);
					$query4->bindValue(4, $driver1, PDO::PARAM_INT);
					$query4->bindValue(5, $year, PDO::PARAM_INT);
					$resultDriver1 = $query4->execute();
					
					$query4->bindValue(4, $driver2, PDO::PARAM_INT);
					$resultDrier2 = $query4->execute();
					
					if($resultDriver1 && $resultDrier2)
					{
						echo "Driver picks made!<br>\n";
						echo "<a href=\"index.php?content=team&leagueID=".$league."&teamID=".$userID."\">My Team</a><br>\n";
						
					}
					else
					{
						echo "An Error occurred adding picks";
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