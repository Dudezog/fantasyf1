<h1>Remove League?</h1>

<p>
	<h3>Are you sure?</h3><br>
	This <b>cannot</b> be undone.<br>
	Use your browser's Back button to cancel this action.<br>
</p>

<br>
<br>
<br>
<br>
<br>

<hr>

<p>
	<form action="index.php" method="post">
	<input type="hidden" value="<?php echo $_GET['leagueID']; ?>" name="leagueID">
	<input type="hidden" name="content" value="remove_league">
	<input type="submit" value="Delete League">
	</form>
</p>

<hr>

