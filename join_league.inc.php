<?php
	if(isset($_GET['leagueID']))
	{
		//Get league info
		$leagueName = "";
		$moderator = 0;
		$leagueNote = "";
		
		require_once('get_league_info.inc.php');
		
		echo "<h1>Join League</h1>\n";
		echo "You've been invited to join:<br>\n";
		echo "<b>".$leagueName."</b>\n";
		
		echo "<p>Please Log-in to Join\n";
		
		echo "<form action=\"add_league_member_validate\" method=\"post\" target=\"_self\">\n";
		echo "<b>User Name:</b><br>\n";
		echo "<input type=\"text\" size=\"20\" name=\"userName\"><br>\n";
		echo "<p><b>Password:</b><br>\n";
		echo "<input type=\"password\" size=\"20\" name=\"password\"><br>\n";
		echo "<p><input type=\"hidden\" name=\"leagueID\" value=".$_GET['leagueID'].">\n";
		echo "<input type=\"submit\" value=\"Join League\">\n";
		echo "</form>\n";

		echo "<p>If you do not have an account, register for free to create one!</p>\n";
		echo "<p><a href=\"index.php?content=register\">Create Account</a></p>\n";
	}
	else
	{
		echo "An error occured.";
	}


?>