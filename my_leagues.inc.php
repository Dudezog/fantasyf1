	<p>
		<u>
			My Leagues
		</u>
	</p>

<?php

	if(isset($_COOKIE['userID']) && isset($_COOKIE['userName']))
	{

		require_once('get_my_leagues.inc.php');
		
		echo "<p><h3>Create League</h3></p>";
		echo "<p><a href=\"index.php?content=create_league\">Create New League</a>";
		
	}
	else
	{
		require_once('login_fail.inc.php');
	}

?>