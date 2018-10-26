<?php

	if(isset($_COOKIE['userID']))
	{
		if(isset($_POST['leagueName']) && isset($_POST['players']) && isset($_POST['note']))
		{
			$leagueName = $_POST['leagueName'];
			$numPlayers = $_POST['players'];
			$note = $_POST['note'];
			
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
				
			   if ($result)
			   {
				   $lastID = $con->lastInsertId();
				   echo "League Created!";
				   
				   //Add Leagure Creator as League Memeber
				   if(!($query2 = $con->prepare("INSERT into memberships (LeagueID, UserID, IsJoined)". 
					"VALUES(?, ?, ?)")))
					{
						echo "Prepare failed: (" . $con->errno . ") " . $con->error;
					}
				   $query2->bindValue(1, $lastID, PDO::PARAM_INT);
				   $query2->bindValue(2, $_COOKIE['userID'], PDO::PARAM_INT);
				   $query2->bindValue(3, 1, PDO::PARAM_INT);				   
				   
				   $result2 = $query2->execute();
				   
				   if($result2)
				   {
					   $_GET['leagueID'] = $lastID;				   
					   require_once('invite_players.inc.php');
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