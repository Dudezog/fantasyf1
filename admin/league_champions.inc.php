<form action="admin.php" method="post">

	<select name ="choice" id="choice" required>"; 
		<option value ="1">Mid Season Champions</option>
		<option value ="2">Second Season Champions</option>
		<option value ="3">League Champion</option>
	</select>

	<input type="hidden" name="content" value="add_league_champions">
	<input name="goButton" type="submit" value="Assign Championships">

</form>