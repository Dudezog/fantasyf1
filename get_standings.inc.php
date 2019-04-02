<?php
    $year = date('Y');    
    require_once('race_date_functions.inc.php');	
	$currentRace = getRaceNum();	
	$range;

	//Get LeagueName
	if(!($query = $con->prepare("SELECT LeagueName FROM leagues WHERE LeagueID = ?")))
	{
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
	
	$query->bindValue(1, $_GET['leagueID'], PDO::PARAM_INT);
	$query->execute();
	$row = $query->fetch();
	echo "<center><h2>".$row['LeagueName']."</h2></center>\n";
	

	
	if($currentRace > 9)
	{
		echo "<p><h3>Winners</h3></p>\n";
		
		//Get mid season champion
		if(!($query = $con->prepare("SELECT champions.Winner1UserID, users.UserID, users.UserName 
			FROM champions, users 
			WHERE LeagueID = ?
			AND Season = ?
			AND champions.Winner1UserID = users.UserID")))
		{
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		
		$query->bindValue(1, $_GET['leagueID'], PDO::PARAM_INT);
		$query->bindValue(2, $year, PDO::PARAM_STR);
		$query->execute();
		$row = $query->fetch();
		
		echo "<p><b>Mid-Season Champion</b><br>\n".$row['UserName']."<br>\n";
		
		if($currentRace >= 19)
		{
			//Get 2nd season champion
			if(!($query = $con->prepare("SELECT champions.Winner2UserID, users.UserID, users.UserName 
				FROM champions, users 
				WHERE LeagueID = ?
				AND Season = ?
				AND champions.Winner2UserID = users.UserID")))
			{
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			
			$query->bindValue(1, $_GET['leagueID'], PDO::PARAM_INT);
			$query->bindValue(2, $year, PDO::PARAM_STR);
			$query->execute();
			$row = $query->fetch();
			
			echo "<p><b>Second-Season Champion </b><br>\n".$row['UserName']."<br>\n";
			
			//Get our Champion
			if($currentRace == 20)
			{
				if(!($query = $con->prepare("SELECT champions.ChampionUserID, users.UserID, users.UserName 
					FROM champions, users 
					WHERE LeagueID = ?
					AND Season = ?
					AND champions.ChampionUserID = users.UserID")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
				
				$query->bindValue(1, $_GET['leagueID'], PDO::PARAM_INT);
				$query->bindValue(2, $year, PDO::PARAM_STR);
				$query->execute();
				$row = $query->fetch();
				
				echo "<p><b>League Champion </b><br>\n".$row['UserName']."<br>\n";
			}
			
		}
		
	}
	

	
	
	echo "<table bgcolor=\"#FFFFFF\" width=\"100%\">\n";

	echo "<tr>\n";
	echo "<td align=\"center\" colspan=3>\n";
	echo "<font color=\"#000000\"><h2>Standings</h2></font>\n";
	echo "</td>\n";
	echo "</tr>\n";
	
	//Get Current Season Standing
	$seasonTitle = "";
	if($currentRace < 10)
	{
		$range = 0;
		$seasonTitle = "Current Season (Races 1-10)";
	}
	elseif($currentRace > 9 && $currentRace < 20)
	{
		$range = 10;
		$seasonTitle = "Current Season (Races 11-20)";
	}
	else
	{
		$seasonTitle = "Current Season (Races 21)";
		$range = 21;
	}
	
		echo "<tr>\n";
		echo "<td colspan=3 align=\"center\" bgcolor=\"#000000\">\n";
		echo "<font color=\"#FFFFFF\"><h3><u>".$seasonTitle."</u></h3></font>\n";
		echo "</td>\n";
		echo "</tr>\n";
	
	    echo "<tr>\n";
    echo "<td align=\"center\">\n";
	echo "<font color=\"#000000\">Team</font>\n";
	echo "</td>\n";
    
    echo "<td align=\"center\">\n";
	echo "<font color=\"#000000\">Points</font>\n";
	echo "</td>\n";
    
    echo "<td align=\"center\">\n";
	echo "<font color=\"#000000\">Behind</font>\n";
	echo "</td>\n";
    
	echo "</tr>\n";
    
    //NOT USING 'SUM(results.Total) AS TOTAL' BECAUSE GODADDY IS AWEFUL AND WON'T LET ME REFER TO A ROW BY ALIAS IN PHP
	// echo $row['SUM(results.Total)'] works
	if(!($query = $con->prepare("SELECT picks.* , results.* , SUM(results.Total) , users.UserID, users.UserName
                                FROM picks, results, users
                                WHERE picks.LeagueID =  ?
                                AND picks.Season =  ?
                                AND picks.TrackID >= ?
                                AND picks.TrackID < ?
                                AND picks.DriverID = results.DriverID
                                AND picks.TrackID = results.TrackID
                                AND picks.Season = results.Season
                                AND picks.UserID = users.UserID
                                GROUP BY picks.UserID
                                ORDER BY SUM(results.Total) DESC")))
	{
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
	
	$query->bindValue(1, $_GET['leagueID'], PDO::PARAM_INT);
	$query->bindValue(2, $year, PDO::PARAM_INT);
	$query->bindValue(3, $range, PDO::PARAM_INT);
	$query->bindValue(4, $currentRace, PDO::PARAM_INT);
	$query->execute();

	$rowCount = $query->rowCount();
	
	if ($rowCount == 0)
	{
			echo "<tr>\n";
			echo "<td align=\"center\" colspan=3>\n";
			echo "<font color=\"#000000\">Point totals not available yet.</font>\n";
			echo "</td>\n";
			echo "</tr>\n";
	}
	else
	{
		
		$pointsBehind = 0;
		$count = 0;
		
		while($row = $query->fetch())
		{
			if($count % 2 == 0)
			{
				$textFont = "000000";
				$bgColor = "FFFFFF";
			}
			else
			{
				$textFont = "FFFFFF";
				$bgColor = "000000";
			}
			
			echo "<tr>\n";
			echo "<td bgcolor=\"#".$bgColor."\">\n";
			echo "<a href=\"index.php?content=userprofile&userID=".$row['UserID']."&leagueID=".$_GET['leagueID']."\">".$row['UserName']."</a>";
			echo "</td>\n";
			
			echo "<td bgcolor=\"#".$bgColor."\">\n";
			echo "<font color=\"#".$textFont."\">".$row['SUM(results.Total)']."</font>\n";
			echo "</td>\n";
			
			if($pointsBehind > 0)
			{
				echo "<td bgcolor=\"#".$bgColor."\">\n";
				echo "<font color=\"#".$textFont."\"> (".($row['SUM(results.Total)'] - $pointsBehind).")</font>\n";
				echo "</td>\n";
			
			}
			else{
				echo "<td bgcolor=\"#".$bgColor."\">\n";
                echo " - ";
				echo "</td>\n";
				
			}
            
                echo "</tr>\n";
			
			$pointsBehind += ($row['SUM(results.Total)'] - $pointsBehind);
			$count++;
			
			
		}
	}
    
    echo "</table>\n";
    
    echo "<br><br>";
	
	//Get Total Season Standings
	echo "<table bgcolor=\"#FFFFFF\" width=\"100%\">\n";

	echo "<tr>\n";
	echo "<td align=\"center\" bgcolor=\"#000000\" colspan=3>\n";
	echo "<font color=\"#FFFFFF\"><h2>Season Totals</h2></font>\n";
	echo "</td>\n";
	echo "</tr>\n";
    
        echo "<tr>\n";
    echo "<td align=\"center\">\n";
	echo "<font color=\"#000000\">Team</font>\n";
	echo "</td>\n";
    
    echo "<td align=\"center\">\n";
	echo "<font color=\"#000000\">Points</font>\n";
	echo "</td>\n";
    
    echo "<td align=\"center\">\n";
	echo "<font color=\"#000000\">Behind</font>\n";
	echo "</td>\n";
    
	echo "</tr>\n";
	
	if(!($query = $con->prepare("SELECT picks.*,
								results.*, SUM(results.Total),
								users.UserID, users.UserName
								FROM picks, results, users
								WHERE 
									picks.LeagueID = ? 
									AND picks.Season = ?
									AND picks.TrackID < ?									
									AND picks.DriverID = results.DriverID
									AND picks.TrackID = results.TrackID
									AND picks.Season = results.Season
									AND picks.UserID = users.UserID
								GROUP BY picks.UserID    
								ORDER BY SUM(results.Total) DESC")))
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
			echo "<tr>\n";
			echo "<td align=\"center\" colspan=3>\n";
			echo "<font color=\"#000000\">Point totals not available yet.</font>\n";
			echo "</td>\n";
			echo "</tr>\n";
	}
	else
	{
		
		$pointsBehind = 0;
		$count = 0;
		
		while($row = $query->fetch())
		{
			if($count % 2 == 0)
			{
				$textFont = "000000";
				$bgColor = "FFFFFF";
			}
			else
			{
				$textFont = "FFFFFF";
				$bgColor = "000000";
			}
			
			echo "<tr>\n";
			echo "<td bgcolor=\"#".$bgColor."\">\n";
			echo "<a href=\"index.php?content=userprofile&userID=".$row['UserID']."&leagueID=".$_GET['leagueID']."\">".$row['UserName']."</a>";
			echo "</td>\n";
			
			echo "<td bgcolor=\"#".$bgColor."\">\n";
			echo "<font color=\"#".$textFont."\">".$row['SUM(results.Total)']."</font>\n";
			echo "</td>\n";
			
			if($pointsBehind > 0)
			{
				echo "<td bgcolor=\"#".$bgColor."\">\n";
				echo "<font color=\"#".$textFont."\"> (".($row['SUM(results.Total)'] - $pointsBehind).")</font>\n";
				echo "</td>\n";
			
			}
			else{
				echo "<td bgcolor=\"#".$bgColor."\">\n";
				echo "</td>\n";
				
			}
            
                echo "</tr>\n";
			
			$pointsBehind += ($row['SUM(results.Total)'] - $pointsBehind);
			$count++;			
			
		}
				
			
	}
    
    echo "</table>";


?>