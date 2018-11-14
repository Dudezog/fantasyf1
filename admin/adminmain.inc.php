<?php

	if(isset($_GET['race']))
	{
		$raceNum = $_GET['race'];
	}
	else
	{
		$raceNum = getRaceNum();
	}
		//Need to offset array for url
		$raceNum--;
		
		$url = "http://localhost/fantasyf1/admin/tools/index.php?id=".$raceNum;
		$json = file_get_contents(''.$url.'');
		$obj = json_decode($json);
		
		echo "<textarea rows =\"25\" cols=\"100\">";
		echo $json;
		echo "</textarea>";
		
		if(!$obj->Error)
		{
			echo "<form action=\"admin.php\" method=\"post\">\n"; 
			echo "<input type=\"hidden\" name=\"race\" value=\"".$raceNum."\">\n"; 
			echo "<input type=\"hidden\" name=\"content\" value=\"add_results\">\n";  
			echo "<input name=\"goButton\" type=\"submit\" value=\"Apply Results\" />\n";  
			echo "</form>\n";
			
		}

?>