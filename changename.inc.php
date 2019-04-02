<center>
<table border="0" cellpadding="3" cellspacing="10" bgcolor="#FFFFFF">
<tr><td>
<?php
//Make sure user is logged in before doing anything
if(isset($_COOKIE['userID']))
{
$userid = $_COOKIE['userID'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$baduser = 0;
 
if (get_magic_quotes_gpc())
	{
      $teamName = stripslashes($teamName);
	}
//Check if data was entered
	if (trim($firstName) == '')
	{
		echo "<h2>Sorry, you did not enter a First Name.</h2><br>\n";
		echo "<a href=\"index.php?content=usersettings\">Try again</a><br>\n";
		$baduser = 1;
	}
	
	if (trim($lastName) == '')
	{
		echo "<h2>Sorry, you did not enter a Last Name.</h2><br>\n";
		echo "<a href=\"index.php?content=usersettings\">Try again</a><br>\n";
		$baduser = 1;
	}

	if ($baduser != 1)
	{

	$query = $con->prepare("UPDATE users set FirstName= ?, LastName= ? WHERE UserID=?");
	$query->bindValue(1, $firstName, PDO::PARAM_STR);
	$query->bindValue(2, $lastName, PDO::PARAM_STR);
	$query->bindValue(3, $userid, PDO::PARAM_STR);
	$result = $query->execute();

	if($result)
	{
		echo "<h2>Name updated!</h2><br>";
		echo "<a href=\"index.php?content=usersettings\">User Settings</a><br>";
	}
	else 
	{
		echo "<h2>Error updating Team Name</h2><br>";
		echo "<a href=\"index.php?content=usersettings\">User Settings</a><br>";
	}
}

//"if (is set)" closing bracket
}
else
{
include('warninglogin.inc.php');
}
?>
</td></tr></table></center>