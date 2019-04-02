<?php

	if(isset($_POST['choice']))
	{
		
		$choice = $_POST['choice'];
		$range1;
		$range2;
		$parameters;
		$badUser = false;
		$year = date("Y");
		
		
		switch($choice)
		{
			case 1:
				$range1 = 0;
				$range2 = 9;
				$parameters = "Winner1UserID";
				$badUser = checkBadUser($con, $range1, $range2);
			break;
			
			case 2:
				$range1 = 10;
				$range2 = 19;
				$parameters = "Winner2UserID";
				$badUser = checkBadUser($con, $range1, $range2);
			break;
			
			case 3:
				$range1 = 20;
				$range2 = 20;
				$parameters = "ChampionUserID";
				$badUser = checkBadUser($con, $range1, $range2);
			break;
		}
		

		if(!$badUser)
		{
		
			//Get leagues
			if(!($query = $con->prepare("SELECT LeagueID FROM leagues")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
				$query->execute();
				
				while($row = $query->fetch())
				{
					$winner = getChampion($row['LeagueID'], $con, $range1, $range2);
					
					if(!($query2 = $con->prepare("UPDATE champions SET ".$parameters."= ? 
					WHERE LeagueID = ?
					AND SEASON = ?")))
					{
						echo "Prepare failed: (" . $con->errno . ") " . $con->error;
					}
					$query2->bindValue(1, $winner, PDO::PARAM_INT);
					$query2->bindValue(2, $row['LeagueID'], PDO::PARAM_INT);
					$query2->bindValue(3, $year, PDO::PARAM_STR);
					$result2 = $query2->execute();
					
					if($result2)
					{
						echo "<p>".$parameters."  Updated As User:  .".$winner."  For League #:  ".$row['LeagueID']."</p>\n";
					}
					else
					{
						echo "<p>Error updating League Champion for League #: ".$row['LeagueID']."</p>\n";
					}					
					
				}
		}
		else
		{
			echo "<p>Could not assign Champions.  Race data for that range is missing.";
		}
		
	}
	else
	{
		echo "Correct Parameters not passed";
	}
	
	
		function checkBadUser($con, $range1, $range2)
		{
			$badUser = false;
			$year = date("Y");
			
			if(!($query = $con->prepare("SELECT COUNT(ResultID) AS 'RecordCount', TrackID, Season 
			FROM results 
			WHERE Season=? 
			AND TrackID BETWEEN ? AND ?")))
			{
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			$query->bindValue(1, $year, PDO::PARAM_STR);
			$query->bindValue(2, $range1, PDO::PARAM_INT);
			$query->bindValue(3, $range2, PDO::PARAM_INT);
			$query->execute();
			
			$row = $query->fetch();
			
			if($row['RecordCount'] != 210)
			{
				$badUser = true;				
			}
			
			return $badUser;
			
		}
		
		function getChampion($leagueID, $con, $range1, $range2)
		{
			$year = date("Y");
			
			if(!($query = $con->prepare("SELECT UserID, UserName, Points FROM(
			(SELECT picks.PickID, picks.UserID AS 'User1', picks.LeagueID AS 'League1', picks.TrackID AS 'Track1', 
			picks.DriverID AS 'Driver1', picks.Season AS 'Season1',
			results.*, SUM(results.Total) AS 'Points',
			users.UserID, users.UserName
			FROM picks, results, users
			WHERE 
				picks.LeagueID = ? 
				AND picks.Season = ?	   
				AND picks.DriverID = results.DriverID
				AND picks.TrackID = results.TrackID
				AND results.TrackID BETWEEN ? AND ?
				AND PICKS.Season = results.Season
				AND picks.UserID = users.UserID
			GROUP BY picks.UserID) AS T
			) 
		WHERE Points = (
			SELECT MAX(Points) FROM (
				(SELECT picks.PickID, picks.UserID AS 'User1', picks.LeagueID AS 'League1', picks.TrackID AS 'Track1', 
				picks.DriverID AS 'Driver1', picks.Season AS 'Season1',
				results.*, SUM(results.Total) AS 'Points',
				users.UserID, users.UserName
				FROM picks, results, users
				WHERE 
					picks.LeagueID = ? 
					AND picks.Season = ?	   
					AND picks.DriverID = results.DriverID
					AND picks.TrackID = results.TrackID
					AND results.TrackID BETWEEN ? AND ?
					AND PICKS.Season = results.Season
					AND picks.UserID = users.UserID
				GROUP BY picks.UserID) AS T2
				)
			)")))
			{
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			$query->bindValue(1, $leagueID, PDO::PARAM_INT);
			$query->bindValue(2, $year, PDO::PARAM_STR);
			$query->bindValue(3, $range1, PDO::PARAM_INT);
			$query->bindValue(4, $range2, PDO::PARAM_INT);
			$query->bindValue(5, $leagueID, PDO::PARAM_INT);
			$query->bindValue(6, $year, PDO::PARAM_STR);
			$query->bindValue(7, $range1, PDO::PARAM_INT);
			$query->bindValue(8, $range2, PDO::PARAM_INT);
			$query->execute();
			
			$rowCount = $query->rowCount();
			$winner = null;
			
			if($rowCount == 1)
			{
				$row = $query->fetch();
				$winner = $row['UserID'];				
			}
			else
			{
				//Tie breaker 1
				//Most first places
				$winner = getTieBreaker($con, 1, $leagueID, $year, $range1, $range2);
				
				if($winner = null)
				{
					//Tie breaker 2
					//Most 2nd places
					$winner = getTieBreaker($con, 2, $leagueID, $year, $range1, $range2); 
					
					if($winner = null)
					{
						//Tie breaker 3
						//Most 3rd places
						$winner = getTieBreaker($con, 3, $leagueID, $year, $range1, $range2);
						
						if($winner = null)
						{
							//Tie breaker 4
							//Most Pole Positions
							$winner = getTieBreaker($con, 4, $leagueID, $year, $range1, $range2);
							
							if($winner = null)
							{
								//Tie breaker 5
								//Most Fastest Laps
								$winner = getTieBreaker($con, 5, $leagueID, $year, $range1, $range2);
								
								if($winner = null)
								{
									$winner = -1;
								}
							}
						}
					}
				}
			}
			
			return $winner;
			
		}
		
		function getTieBreaker($con, $tieBreakerNum, $leagueID, $year, $range1, $range2)
		{
			$winner = null;
			$table = null;
			$parameters = null;
			
			switch($tieBreakerNum)
			{
				case 1:  $table = "FirstPlaces";
						 $parameters = "COUNT(IF(results.RaceFinishPoints = 50, 1, NULL)) 'FirstPlaces',";
				break;
				
				case 2:  $table = "SecondPlaces";
						 $parameters = "COUNT(IF(results.RaceFinishPoints = 38, 1, NULL)) 'SecondPlaces',";
				break;
				
				case 3:  $table = "ThirdPlaces";
						 $parameters = "COUNT(IF(results.RaceFinishPoints = 30, 1, NULL)) 'ThirdPlaces',";
				break;
				
				case 4:  $table = "PolePositions";
						 $parameters = "COUNT(IF(results.QualifyingPoints = 5, 1, NULL)) 'PolePositions',";
				break;
				
				case 5:  $table = "FastLaps";
						 $parameters = "COUNT(IF(results.FastLapPoints = 2, 1, NULL)) 'FastLaps',";
				break;
				
				default:  $table = "FirstPlaces";
						  $parameters = "COUNT(IF(results.RaceFinishPoints = 50, 1, NULL)) 'FirstPlaces',";
			}
			
			if(!($query = $con->prepare("SELECT UserID, UserName, ".$table." FROM(
			(SELECT picks.PickID, picks.UserID AS 'User1', picks.LeagueID AS 'League1', picks.TrackID AS 'Track1', 
			picks.DriverID AS 'Driver1', picks.Season AS 'Season1',
			results.*,"
			.$parameters." 
			users.UserID, users.UserName
			FROM picks, results, users
			WHERE 
				picks.LeagueID = ? 
				AND picks.Season = ?	   
				AND picks.DriverID = results.DriverID
				AND picks.TrackID = results.TrackID
				AND results.TrackID BETWEEN ? AND ?
				AND PICKS.Season = results.Season
				AND picks.UserID = users.UserID
			GROUP BY picks.UserID) AS T
				) 
			WHERE ".$table." = (
				SELECT MAX(".$table.") FROM (
					(SELECT picks.PickID, picks.UserID AS 'User1', picks.LeagueID AS 'League1', picks.TrackID AS 'Track1', 
					picks.DriverID AS 'Driver1', picks.Season AS 'Season1',
			results.*,". 
			$parameters." 
			users.UserID, users.UserName
			FROM picks, results, users
			WHERE 
				picks.LeagueID = ? 
				AND picks.Season = ?	   
				AND picks.DriverID = results.DriverID
				AND picks.TrackID = results.TrackID
				AND results.TrackID BETWEEN ? AND ?
				AND PICKS.Season = results.Season
				AND picks.UserID = users.UserID
			GROUP BY picks.UserID) AS T2
					)
				)")))
			{
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			$query->bindValue(1, $leagueID, PDO::PARAM_INT);
			$query->bindValue(2, $year, PDO::PARAM_STR);
			$query->bindValue(3, $range1, PDO::PARAM_INT);
			$query->bindValue(4, $range2, PDO::PARAM_INT);
			$query->bindValue(5, $leagueID, PDO::PARAM_INT);
			$query->bindValue(6, $year, PDO::PARAM_STR);
			$query->bindValue(7, $range1, PDO::PARAM_INT);
			$query->bindValue(8, $range2, PDO::PARAM_INT);
			$query->execute();
			
			$rowCount = $query->rowCount();
			
			if($rowCount == 1)
			{
				$row = $query->fetch();
				$winner = $row['UserID'];
			}
			
			
			return $winner;
		}

		

?>