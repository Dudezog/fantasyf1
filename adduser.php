<?php
//Again, Cookie stuff, avoiding Header errors
//Connect to database again
include('f1_db.inc.php');

$userName = $_POST['userid'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$email = $_POST['email'];

$badUser = false;
$errorMsg = false;
$result = false;


  if (get_magic_quotes_gpc())
   {
		$userName = $_POST['userid'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$email = $_POST['email'];      
   }

// Check if userid was entered
if (trim($userName) == '')
{
   echo "Please enter a User Name<br>";
   $badUser = true;
}

//Check if password was entered
if (trim($password) == '')
{
   echo "Please enter a password<br>";
   $badUser = true;
}
//Check if password and confirm password match
if ($password != $password2)
{
   echo "Passwords did not match<br>";
   $badUser = true;
}

//Check if e-mail was entered
if (trim($email) == '')
{
   echo "Please enter an e-mail<br>";
   $badUser = true;
}

//Check if user Name is already in database
//Prepare the statement
 if(!($query = $con->prepare("SELECT UserName from users WHERE UserName = ?")))
 {
    echo "Prepare failed: (" . $con->errno . ") " . $con->error;
}
	$query->bindValue(1, $userName, PDO::PARAM_STR);
	$query->execute();
	//Check if userid already exists
	$rowCount = $query->rowCount();
	if ($rowCount != 0)
	{
		echo "That User Name is already taken<br>";
        $badUser = true;	
	}

//Check if e-mail is already in database
//Prepare the statement
 if(!($query = $con->prepare("SELECT Email from users WHERE Email = ?"))){
    echo "Prepare failed: (" . $con->errno . ") " . $con->error;  
}
	$query->bindValue(1, $email, PDO::PARAM_STR);
	$query->execute();
	$rowCount = $query->rowCount();
	if ($rowCount != 0)
	{
	  echo "That e-mail is already registered<br>";
      $badUser = true;	
	}	 
	 
if (!$badUser)
{
   //Everything passed, enter userid in database
    if(!($query = $con->prepare("INSERT into users (UserName, Password, Email)". 
	"VALUES(?, PASSWORD(?), ?)")))
	{
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
   $query->bindValue(1, $userName, PDO::PARAM_STR);
   $query->bindValue(2, $password, PDO::PARAM_STR);
   $query->bindValue(3, $email, PDO::PARAM_STR);  
   
   $result = $query->execute();
	
	//If success, get the user's ID #
   if ($result)
   {
	   	if(!($query2 = $con->prepare("SELECT UserID, UserName from users where UserName=?")))
	{
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
	
		$query2->bindValue(1, $userName, PDO::PARAM_STR);
		$query2->execute();
		
		$rowCount2 = $query2->rowCount();
		
		if ($rowCount2 != 0)
		{		
			$row = $query2->fetch();
			$userID = $row['UserID'];
			$userName = $row['UserName'];

			setcookie("userID", $userID, time() + (86400 * 7), "/");	
			setcookie("userName", $userName, time() + (86400 * 7), "/");

		}
   }
}   
else  
{
	$errorMsg = true;
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
			if($errorMsg)
			{	
				 echo "<tr><td>";
				 echo "<center>";
				 echo "<button type=\"button\" onclick=\"javascript:history.back()\">Go Back</button><br><br>";
				 echo "<a href=\"index.php\">Return to Home</a><br>";
				 echo "</center>";

			}
 
			if($result)
			{
			   echo "<h1>Loading...</h1>";
			   //Redirect user to My Fridge page
				echo "<script> location.replace(\"index.php?content=dash\"); </script>";
			}

		?>
		
		<?php
			include('footer.inc.php');
		?>
	
	</body>
</html>