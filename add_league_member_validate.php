<?php
	/*
	* A special validate user page used for joining leagues
	* We make sure user name & pass match 
	* On success, insert their membership & log them in
	*/

	//All Cookies need to be set before header
	//Do this stuff first
	if(isset($_POST['userName'])&& isset($_POST['password']) && isset($_POST['leagueID']))
	{
		//We left index.php, so reconnect to database
		include('f1_db.inc.php');
		
		$userName = $_POST['userName'];
		$password = $_POST['password'];
		$leagueID = $_POST['leagueID'];

		if(!($query = $con->prepare("SELECT UserID, UserName from users where UserName=? and Password = PASSWORD(?)")))
		{
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		
		$query->bindValue(1, $userName, PDO::PARAM_STR);
		$query->bindValue(2, $password, PDO::PARAM_STR);
		$query->execute();
		$rowCount = $query->rowCount();
		//userName & password did not match any entries in database
		if ($rowCount == 0)
		{    
			$error = true;
		} 
		else
		{ 
			//Log in successful, save userID, userName in cookies
			$error = false;
			$row = $query->fetch();
			
			$userID = $row['UserID'];
			$userName = $row['UserName'];
			
			//Save user info in cookies		
			//86400 = 1 day, cookie set for 1 week
			setcookie("userID", $userID, time() + (86400 * 7), "/");
			setcookie("userName", $userName, time() + (86400 * 7), "/");	
			
			//Add user to league
			//Make sure user isn't already in league
			if(!($query2 = $con->prepare("SELECT UserID from memberships where LeagueID=? and UserID = ?")))
			{
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			
			$query2->bindValue(1, $leagueID, PDO::PARAM_INT);
			$query2->bindValue(2, $userID, PDO::PARAM_INT);
			$query2->execute();
			$rowCount2 = $query2->rowCount();
			 
			if ($rowCount2 != 0)
			{    
				$error = true;
			}
			
			if(!$error)
			{
				if(!($query2 = $con->prepare("INSERT into memberships (LeagueID, UserID, IsJoined)". 
						"VALUES(?, ?, ?)")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
			   $query2->bindValue(1, $leagueID, PDO::PARAM_INT);
			   $query2->bindValue(2, $userID, PDO::PARAM_INT);
			   $query2->bindValue(3, 1, PDO::PARAM_INT);				   
			   
			   $result2 = $query2->execute();
			   
			   if(!$result2)
			   {
				   $error = true;
			   }
			   else
			   {
				   $year = date("Y");
				   //Insert users base picks for season
				  if(!($query3 = $con->prepare("INSERT INTO picks (UserID, LeagueID, TrackID, DriverID, Season) 
						VALUES(?, ?, ?, ?, ?)")))
					{
						echo "Prepare failed: (" . $con->errno . ") " . $con->error;
					}
					$query3->bindValue(1, $userID, PDO::PARAM_INT);
					$query3->bindValue(2, $leagueID, PDO::PARAM_INT);
					
					$query3->bindValue(4, 0, PDO::PARAM_INT); //Driver 0 == "No Pick Driver"
					$query3->bindValue(5, $year, PDO::PARAM_INT);				   
				   
				    $error = false;
				    
					//Loop through, bind races 0-20 and add our "no picks" for each race
					for($x = 0; $x < 21; $x++)
					{
						$query3->bindValue(3, $x, PDO::PARAM_INT);
						//Execute x2 to make 2 No picks for each race
						$result1 = $query3->execute();
						$result2 = $query3->execute();
						
						if(!$result1 || !$result2)
					    {
						   $error = true;
					    }
					}	   
				   
			   }
			   
		   }		   
		}
	}
	else
	{
	 $error = true;	
	}

?>
<html>
	<head>
		<title>
			Fantasy F1
		</title>
		
		<link rel="stylesheet" type="text/css" href="master.css" />
	</head>

	<body>
		<?php
			include('header.inc.php');
		?>
	
	
		<?php
			if($error)
			{
					echo "<tr><td><h2>Sorry, there was an error joining league.</h2></td>\n";
					echo "<tr><td><a href=\"index.php?content=join_league&leagueID=".$leagueID."\">Try again</a></td></tr>\n";
			}
			else
			{
				//Redirect user to members area
				echo "<script> location.replace(\"index.php?content=my_leagues\"); </script>";
			}

		?>
		
		<?php
			include('footer.inc.php');
		?>
	
	</body>
</html>