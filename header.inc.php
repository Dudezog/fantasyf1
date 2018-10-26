<h1>
	Fantasy <i>F1</i>
</h1>
<?php
	if(isset($_COOKIE['userID']) && isset($_COOKIE['userName']))
	{
		$userID = $_COOKIE['userID'];
		echo $_COOKIE['userName'];
	}
?>