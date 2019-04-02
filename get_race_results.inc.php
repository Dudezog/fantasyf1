<table bgcolor="#FFFFFF" width="100%">

<tr>
    <td colspan="2" align="center">
		<h3>Results</h3>
	</td>
</tr>


<?php

	require_once('race_date_functions.inc.php');	
	$currentRace = getRaceNum();
    $currentRace--;

	//Get Race name
	if(!($query = $con->prepare("SELECT RaceName from tracks WHERE TrackID = ?")))
	{
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
	
	$query->bindValue(1, $currentRace, PDO::PARAM_INT);
	$query->execute();

	$row = $query->fetch();
	
	echo "<tr>\n";
	echo "<td colspan=\"2\" align=\"center\" bgcolor=\"#000000\">\n";
	echo "<font color=\"#FFFFFF\"><h3>".$row['RaceName']."</h3></font>\n";
	echo "</td>\n";
	echo "</tr>\n";
	
    $year = date('Y');
    
	//Get Results from last race
	if(!($query = $con->prepare("SELECT results.DriverID, results.Total, 
		drivers.DriverID, drivers.DriverName 
		FROM results, drivers
		WHERE results.TrackID = ? 
		AND drivers.DriverID > 0 
		AND drivers.DriverID = results.DriverID 
        AND results.Season = ?
		ORDER BY Total DESC")))
	{
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
	
	$query->bindValue(1, $currentRace, PDO::PARAM_INT);
    $query->bindValue(2, $year, PDO::PARAM_STR);
	$query->execute();

	$rowCount = $query->rowCount();
	
	if ($rowCount == 0)
	{
        echo "<tr>\n";
    	echo "<td colspan=\"2\" align=\"center\" bgcolor=\"#FFFFFF\">\n";
		echo "<font color=\"#000000\">Sorry!  Results are not in yet!</font>\n";
        echo "</td>\n";
    	echo "</tr>\n";
	}
	else
	{
		
		$count = 0;
		
		while($row = $query->fetch())
		{
			if($count % 2 == 0)
			{
				echo "<tr>\n";
				echo "<td bgcolor=\"#FFFFFF\">\n";
				echo "<font color=\"#000000\">".$row['DriverName']."</font>";
                echo "</td>";
                echo "<td bgcolor=\"#FFFFFF\">\n";
                echo "<font color=\"#000000\">".$row['Total']."</font>\n";
				echo "</td>\n";
                echo "</tr>\n";
				
			}
			else
			{
                echo "<tr>\n";
    			echo "<td bgcolor=\"#000000\">\n";
				echo "<font color=\"#FFFFFF\">".$row['DriverName']."</font>";
                echo "</td>";
                echo "<td bgcolor=\"#000000\">\n";
                echo "<font color=\"#FFFFFF\">".$row['Total']."</font>\n";
				echo "</td>\n";
                echo "</tr>\n";
            
			}
            
            $count++;
		}				
			
	}


?>

</table>