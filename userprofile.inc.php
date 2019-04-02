<?php
    require_once('dash_links.inc.php');	
?>

<div id="standings">
	<?php
		require_once('get_standings.inc.php');
	?>
</div>	

<div id="mypicks">

<table border="0" cellpadding="5" cellspacing="15" bgcolor=#FFFFFF>
<?php

	require_once('race_date_functions.inc.php');

	if(isset($_GET['userID']))
	{
		$userID = $_GET['userID'];
		
			if(!($query = $con->prepare("SELECT UserName FROM users WHERE UserID = ?")))
			{
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			$query->bindValue(1, $userID, PDO::PARAM_INT);
			$query->execute();	
			$row = $query->fetch();
			
			echo "<p><h3>".$row['UserName']."'s Picks</h3>";
			echo "<p>(Picks are viewable on the Friday before the race at 12:00AM CTS)";
			

		
		$year = date('Y');		
			
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
			
				echo "<tr><td>".$tracks[$i]."</td>\n";
			
		
		
			if(!($query = $con->prepare("SELECT picks.*, drivers.DriverID, drivers.DriverName 
			FROM picks, drivers
			WHERE picks.DriverID = drivers.DriverID 
			AND picks.TrackID = ? 
			AND picks.UserID = ? 
			AND LeagueID = ?
			AND Season = ?")))
			{
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			$query->bindValue(1, $i, PDO::PARAM_INT);
			$query->bindValue(2, $_GET['userID'], PDO::PARAM_INT);
			$query->bindValue(3, $_GET['leagueID'], PDO::PARAM_INT);
			$query->bindValue(4, $year, PDO::PARAM_INT);
			$query->execute();
			
			$rowCount = $query->rowCount();
			
			if($_COOKIE['userID'] == $userID)
			{
				
				while($row = $query->fetch())
				{
					echo "<td>".$row['DriverName']."</td>";			
				}
			}
			else
			{
				if(isValidPick($i))
				{
					echo "<td>*****</td>";	
					echo "<td>*****</td>";
				}
				else
				{
					while($row = $query->fetch())
					{
						echo "<td>".$row['DriverName']."</td>";			
					}
					
				}
			}
		
			echo "</tr>\n";
		}	
		
	}
	else
	{
		echo "Error getting user data<br>";
	}


?>
</table>

</div>

<div id="results">
    <?php
		require_once('get_race_results.inc.php');
	?>
</div>		