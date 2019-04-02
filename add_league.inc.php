<?php

	if(isset($_COOKIE['userID']))
	{
		if(isset($_POST['leagueName']) && isset($_POST['players']) && isset($_POST['note']))
		{
			$leagueName = $_POST['leagueName'];
			$numPlayers = $_POST['players'];
			$note = $_POST['note'];
			$year = date("Y");
			
			//Validate form
			$badUser = false;
			
			if(trim($leagueName) == '')
			{
				echo "Please enter a League Name<br>\n";
				$badUser = true;
			}
			
			if(!$badUser)
			{
				date_default_timezone_set("America/Chicago");
				$date = date("y-m-d H:i:s");
				
				if(!($query = $con->prepare("INSERT into leagues (LeagueName, ModeratorID, TotalPlayers, ActivePlayer, LeagueNote, CreatedOn)". 
				"VALUES(?, ?, ?, ?, ?, ?)")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
			   $query->bindValue(1, $leagueName, PDO::PARAM_STR);
			   $query->bindValue(2, $_COOKIE['userID'], PDO::PARAM_INT);
			   $query->bindValue(3, $numPlayers, PDO::PARAM_INT);
			   $query->bindValue(4, $_COOKIE['userID'], PDO::PARAM_INT);
			   $query->bindValue(5, $note, PDO::PARAM_STR);
			   $query->bindValue(6, $date, PDO::PARAM_STR);
			   
			   
			   $result = $query->execute();
			   $leagueID = $con->lastInsertId();
			   $_GET['leagueID'] = $leagueID;
			   
			   //Insert into our Champions-keeping table
			   if(!($query2 = $con->prepare("INSERT into champions (LeagueID, Season)". 
				"VALUES(?, ?)")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
			   $query2->bindValue(1, $leagueID, PDO::PARAM_INT);
			   $query2->bindValue(2, $year, PDO::PARAM_STR);			   
			   
			   $result2 = $query2->execute();
			   
				
			   if ($result && $result2)
			   {
				   
				   echo "League Created!";
				   
				   //Add Leagure Creator as League Memeber
				   if(!($query2 = $con->prepare("INSERT into memberships (LeagueID, UserID, IsJoined)". 
					"VALUES(?, ?, ?)")))
					{
						echo "Prepare failed: (" . $con->errno . ") " . $con->error;
					}
				   $query2->bindValue(1, $leagueID, PDO::PARAM_INT);
				   $query2->bindValue(2, $_COOKIE['userID'], PDO::PARAM_INT);
				   $query2->bindValue(3, 1, PDO::PARAM_INT);				   
				   
				   $result2 = $query2->execute();
				   
				   //Insert League Creator base picks for season
				  if(!($query3 = $con->prepare("INSERT INTO picks (UserID, LeagueID, TrackID, DriverID, Season) 
						VALUES(?, ?, ?, ?, ?)")))
					{
						echo "Prepare failed: (" . $con->errno . ") " . $con->error;
					}
					$query3->bindValue(1, $_COOKIE['userID'], PDO::PARAM_INT);
					$query3->bindValue(2, $leagueID, PDO::PARAM_INT);
					
					$query3->bindValue(4, 0, PDO::PARAM_INT); //Driver 0 == "No Pick Driver"
					$query3->bindValue(5, $year, PDO::PARAM_STR);				   
				   
				    $error = false;
				    
					//Loop through, bind races 0-20 and add our "no picks" for each race
					for($x = 0; $x < 21; $x++)
					{
						$query3->bindValue(3, $x, PDO::PARAM_INT);
						//Execute x2 to make 2 No picks for each race
						$resultA = $query3->execute();
						$resultB = $query3->execute();
						
						if(!$resultA || !$resultB)
					    {
						   $error = true;
					    }
					}			   
				   
				   
				   if($result2 && !$error)
				   {		   
					   require_once('invite_players.inc.php');
					   
					   echo "<p><a href =\"index.php?content=league&leagueID=".$leagueID."\">League Home</a></p>\n";
				   }
				   else
				   {
					   echo "An error occurred Creating League";
				   }
				   
				   
			   }
			   else
			   {
				   echo "Error Creating League";
			   }			
				
			}		
		}
		else
		{
			echo "Error creating league";
		}	
	}
	else
	{
		include('login_fail.inc.php');
	}
	
?>