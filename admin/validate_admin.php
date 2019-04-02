<?php 
	session_start(); 

	//We left index.php, so reconnect to database
	include('f1_db.inc.php');
	
	$userName = $_POST['userName'];
	$password = $_POST['password'];

	if(!($query = $con->prepare("SELECT AdminID, AdminName FROM admins where AdminName=? and Password = PASSWORD(?)")))
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
	   echo "<h2>Sorry, your account was not validated.</h2><br>\n"; 
	   echo "<a href=\"admin.php\">Try again</a><br>\n"; 
	} 
	else
	{
	   $row = $query->fetch();
	   $_SESSION['f1_admin'] = $row['AdminID']; 
	   header("Location: admin.php"); 
	}
?>