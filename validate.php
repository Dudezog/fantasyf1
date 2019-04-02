<?php
	//All Cookies need to be set before header
	if(isset($_POST['userName'])&& isset($_POST['password']))
	{
		//We left index.php, so reconnect to database
		include('f1_db.inc.php');
		
		$userName = $_POST['userName'];
		$password = $_POST['password'];

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
			//userName & password did not match any entries in database
			if($error)
			{
					echo "<tr><td><h2>Sorry, there was an error logging in.</h2></td>\n";
					echo "<tr><td><a href=\"index?content=login\">Try again</a></td></tr>\n";
			}
			else
			{
				//Redirect user to members area
				echo "<script> location.replace(\"index?content=my_leagues\"); </script>";
			}

		?>
		
		<?php
			include('footer.inc.php');
		?>
	
	</body>
</html>