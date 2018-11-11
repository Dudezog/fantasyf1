Fantasy F1  &copy; 
<?php 
	echo date("Y");

	if(isset($_COOKIE['userID']))
	{
		echo "<a href=\"logout.php\">Log Out</a>";
	}
?>