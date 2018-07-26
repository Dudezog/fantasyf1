<?php
if(isset($_COOKIE['userID']) && isset($_COOKIE['userName']))
{
	$userID = $_COOKIE['userID'];
	$userName = $_COOKIE['userName'];
	
	echo "Welcome ".$userName;
	echo "<br><br><br><br>";
	echo "<a href=\"logout.php\">Log Out</a>";
}
else
{
	echo "Error logging in";
}


?>