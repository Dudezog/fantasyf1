<?php

//Set user cookie for time in past to delete it
	setcookie("userID", " ", time() -3600, "/");
	setcookie("userName", " ", time() -3600, "/");

 echo "<script> location.replace(\"index.php\"); </script>";	 
	 
	
?>