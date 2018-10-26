<h3>Invite Players</h3>

<?php
	
	if(isset($_GET['leagueID']))
	{
		echo "Share Link for league:\n";		
		echo "<p>".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?content=join_league&leagueID=".$_GET['leagueID']."</p>\n";
		//echo "<p>".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?content=join_league&leagueID=".$_GET['leagueID']."</p>\n";
	}

?>