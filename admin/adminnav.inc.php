<table width="100%" cellpadding="5" cellpadding="5"> 
  <tr> 
    <td><h3>F1 Administration</h3></td> 
  </tr> 
  <tr> 
    <td><a href="admin.php"><strong>Home</strong></a></td> 
  </tr> 
  <tr> 
    <td><hr size="1" noshade="noshade" /></td> 
  </tr> 
  <div id="adminnav">
<?php 

   if (isset($_SESSION['f1_admin'])) 
   { 
		echo "<tr><td>\n"; 
		echo "<form action=\"admin\" method=\"get\">\n"; 
		echo "<label><font color=\"#663300\" size=\"-1\">Races</font> </label>\n"; 
		echo "<select name =\"race\" id=\"race\" required>"; 

		$raceNum = getRaceNum();

		if(!($query = $con->prepare("SELECT * FROM tracks")))
		{
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		$query->execute();

		$rowCount = $query->rowCount();

		if ($rowCount == 0)
		{
			echo "Error getting tracks";
		}
		else
		{
			while($row = $query->fetch())
			{
				//Set our drop down to current race
				if(!isset($_GET['race']))
				{
					if($row['RaceNumber'] == $raceNum)
					{
						echo "<option value=\"".$row['RaceNumber']."\" selected>".$row['RaceName']."</option>\n";
					}
					else
					{
						echo "<option value=\"".$row['RaceNumber']."\">".$row['RaceName']."</option>\n";
					}
				}
				else
				{
					if($row['RaceNumber'] == $_GET['race'])
					{
						echo "<option value=\"".$row['RaceNumber']."\" selected>".$row['RaceName']."</option>\n";
					}
					else
					{
						echo "<option value=\"".$row['RaceNumber']."\">".$row['RaceName']."</option>\n";
					}
				}
				
					
			}
		}

      echo "<input name=\"goButton\" type=\"submit\" value=\"Load Race\" />\n";  
      echo "</form> </td></tr>\n"; 
	  echo "<tr><td><a href=\"admin.php?content=league_champions\">Edit League Champions</a></td></tr>\n";
	  echo "<tr><td><a href=\"admin.php?content=new_season\">Start New Season</a></td></tr>\n";
   } 
?> 
</div>
</table> 
