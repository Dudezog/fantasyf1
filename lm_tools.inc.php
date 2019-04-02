<?php

	echo "<p><b>League Management Tools</b></p>\n";
	
	require_once('invite_players.inc.php');
	
	echo "<br><br>";
	
	echo "<p><b>Remove League</b></p>\n";
	echo "<p><a href =\"index.php?content=remove_leage_confirm&leagueID=".$_GET['leagueID']."\">Delete League</a>";


?>