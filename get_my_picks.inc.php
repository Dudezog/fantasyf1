<script>
function loadRace()
{
  var xhttp;
  var x = document.getElementById("races").value;
  
  if (window.XMLHttpRequest)
  {
    // code for modern browsers
    xhttp = new XMLHttpRequest();
  } 
  else
  {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  xhttp.onreadystatechange = function()
  {
    if (this.readyState == 4 && this.status == 200)
	{
      document.getElementById("picks").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "get_picks.php?raceid="+x, true);
  xhttp.send();
}
</script>

<table border="0" cellpadding="5" cellspacing="15" bgcolor=#FFFFFF>
		<tr>
			<td>
				<b>
					Race
				</b>
			</td>
			<td>
				<b>
					Driver 1
				</b>
			</td>
			<td>
				<b>
					Driver 2
				</b>
			</td>
		</tr>
		<tr>
			<td>
				<form action="index.php" method="post" target="_self">
	
		<select name ="races" id="races" onchange="loadRace()" required>
<?php
		require_once('race_date_functions.inc.php');
		$raceNum = getRaceNum();
		
		if(!($query = $con->prepare("SELECT * FROM tracks WHERE TrackID >= ?")))
		{
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		$query->bindValue(1, $raceNum, PDO::PARAM_INT);
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
				if($row['RaceNumber'] == $raceNum)
				{
					echo "<option value=\"".$row['RaceNumber']."\" selected>".$row['RaceName']."</option>\n";
				}
				else
				{
					echo "<option value=\"".$row['RaceNumber']."\">".$row['RaceName']."</option>\n";
				}
					
			}
		}

?>
			</select>
			
	</td>
	<td>
		<select name ="driver1" id="driver1" required>
		<?php
			
			if(!($query = $con->prepare("SELECT * FROM drivers WHERE DriverID > 0")))
			{
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			
			$query->execute();
			
			$rowCount = $query->rowCount();
			
			if ($rowCount == 0)
			{
				echo "Error getting drivers\n";
			}
			else
			{
				while($row = $query->fetch())
				{
					echo "<option value=\"".$row['DriverID']."\">".$row['DriverName']."</option>\n";
				}
			}
		?>
		</select>
	</td>
	<td>
		<select name ="driver2" id="driver2" required>
		<?php
			
			if(!($query = $con->prepare("SELECT * FROM drivers WHERE DriverID > 0")))
			{
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			
			$query->execute();
			
			$rowCount = $query->rowCount();
			
			if ($rowCount == 0)
			{
				echo "Error getting drivers\n";
			}
			else
			{
				while($row = $query->fetch())
				{
					echo "<option value=\"".$row['DriverID']."\">".$row['DriverName']."</option>\n";
				}
			}
		?>
		</select>
	</td>
	<td colspan="2">
		<input type="hidden" name="userID" value="<?php echo $_GET['teamID']; ?>">
		<input type="hidden" name="leagueID" value="<?php echo $_GET['leagueID']; ?>">
		<input type="hidden" name="year" value="<?php echo date("Y"); ?>">
		<input type="hidden" name="content" value="submit_picks">
		<input type="submit" value="Submit">
		</form>
	</td>	
</tr>
	<tr>
		<td colspan="3">
			<h3>My Picks</h3>
		</td>
	</tr>
	<tr>
		<?php
			
			//TO-DO:
			//Get All of our picks this seaons and list them in a table
					$tracks = array('Australia',
						'Bahrain',
						'China',
						'Azerbaijan',
						'Spain',
						'Monaco',
						'Canada',
						'France',
						'Austria',
						'Great Britain',
						'Germany',
						'Hungary',
						'Belgium',
						'Italy',
						'Singapore',
						'Russia',
						'Japan',
						'United States',
						'Mexico',
						'Brazil',
						'Abu Dhabi'						
				);
			
			for($i = 0; $i < 21; $i++)
			{
				
				if($i == $raceNum)
				{
					echo "<tr><td><b>*".$tracks[$i]."</b></td>\n";
				}
				else
				{
					echo "<tr><td>".$tracks[$i]."</td>\n";
				}
			
			
				if(!($query = $con->prepare("SELECT picks.*, drivers.DriverID, drivers.DriverName 
				FROM picks, drivers
				WHERE picks.DriverID = drivers.DriverID 
				AND picks.TrackID = ? 
				AND picks.UserID = ? 
				AND LeagueID = ?")))
				{
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
				$query->bindValue(1, $i, PDO::PARAM_INT);
				$query->bindValue(2, $_GET['teamID'], PDO::PARAM_INT);
				$query->bindValue(3, $_GET['leagueID'], PDO::PARAM_INT);
				$query->execute();
				
				$rowCount = $query->rowCount();
				
				if ($rowCount == 0)
				{
					echo "<td>No Picks Made!</td>\n";
				}
				else
				{
					$drivers = "";
					while($row = $query->fetch())
					{
						echo "<td>".$row['DriverName']."</td>";			
					}
						
				}
				echo "</tr>\n";
			}			

		?>
	</tr>
</table>