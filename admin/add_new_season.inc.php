<?php

	if(isset($_POST['season']))
	{
		$season = $_POST['season'];
		//Check season in 'correct'-ish format
		//Verify season is between 2019 and the next 50 years
		$badUser = false;
		if($season < 2018 || $season > 2068)
		{
			$badUser = true;
			echo "<p>Please check your season value.<p>\n";
		}
		
		if(!$badUser)
		{
			echo "Begin new season";
		}
		
	}
	else
	{
		echo "Sorry, could not start new season.  Correct Parameters not passed.\n";
	}


?>

