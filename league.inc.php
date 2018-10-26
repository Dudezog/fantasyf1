<?php

	if(isset($_COOKIE['userID']))
	{
		if(isset($_GET['leagueID']))
		{
			$leagueName = "";
			$moderator = 0;
			$leagueNote = "";
			
			require_once('get_league_info.inc.php');
			
			require_once('dash_links.inc.php');
			
			echo "<h3>".$leagueName."</h3>";
			
			echo "<p><u>League Notes</u><br>";
			echo $leagueNote."<br>";
			
			if($_COOKIE['userID'] == $moderator)
			{
				require_once('lm_tools.inc.php');
			}
			
		}
		else
		{
			echo "Error getting League Info";
		}

	}
	else
	{
		include('login_fail.inc.php');
	}
?>