<?php
//Method for fixing the Finnish characters in Kimi Raikkonen
	function fixKimi($name)
	{
		$name = str_replace("ä", "a", $name);
		$name = str_replace("ö", "o", $name);	
		return $name;
	}

?>