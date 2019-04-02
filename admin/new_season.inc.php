<h1>Start New Season</h1>

<p>
	<b>Note:</b>  This will insert proper records for each league to begin a new season.<br>
	Please verify all steps have been taken to prep the new season.<br>
	Once new season started, it can't be undone or edited without running manual SQL statements.<br>
</p>

<p>
	<b>To-Do</b>
</p>

<ul>
	<li>
		Update Drivers (Constructor Changes, New Drivers, Etc)
	</li>	 
	<li>
		Update Get Race Date Function (race_date_functions.inc.php) in main folder AND Admin folder.<br>  
		(Change race dates for next season, driver pick cut-off dates for each race)<br>
	</li>
</ul>

<form action="admin.php" method="post">
	<input type="number" size="20" name="season" placeholder="<?php echo date("Y")+1; ?>">
	<input type="hidden" name="content" value="add_new_season">
	<input name="goButton" type="submit" value="Create New Season">

</form>