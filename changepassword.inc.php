<center><table border="0" cellpadding="3" cellspacing="10" bgcolor="#FFFFFF"><tr><td><?php//Make sure user is logged in before doing anythingif(isset($_COOKIE['userID'])){$userid = $_COOKIE['userID'];$oldPassword = $_POST['oldpassword'];$newPassword = $_POST['newpassword'];$newPassword2 = $_POST['newpassword2'];$baduser = 0;//Check if password was enteredif (trim($oldPassword) == ''){   echo "<h2>Sorry, you must enter your old password.</h2><br>\n";   echo "<a href=\"index.php?content=usersettings\">Try again</a><br>\n";   $baduser = 1;}if (trim($newPassword) == ''){   echo "<h2>Sorry, you must enter a new password.</h2><br>\n";   echo "<a href=\"index.php?content=usersettings\">Try again</a><br>\n";   $baduser = 1;}//Check if password and confirm password matchif ($newPassword != $newPassword2){   echo "<h2>Sorry, the new passwords you entered did not match.</h2><br>\n";   echo "<a href=\"index.php?content=usersettings\">Try again</a><br>\n";   $baduser = 1;}if ($baduser != 1){//Check if old password was valid	$query = $con->prepare("Select Password from users where UserID=? AND Password = PASSWORD(?)");	$query->bindValue(1, $userid, PDO::PARAM_STR);	$query->bindValue(2, $oldPassword, PDO::PARAM_STR);	$query->execute();	$row_count = $query->rowCount();		if ($row_count == 0)		{			echo "<h3>Sorry, old password did not match</h3>";			echo "<a href=\"index.php?content=usersettings\">Try again</a><br>\n";		}	else 		{			$query = $con->prepare("UPDATE users set Password = PASSWORD(?) WHERE UserID=?");			$query->bindValue(1, $newPassword, PDO::PARAM_STR);			$query->bindValue(2, $userid, PDO::PARAM_STR);			$result = $query->execute();	if($result)	{		echo "<h2>Password updated!</h2><br>";		echo "<a href=\"index.php?content=usersettings\">User Settings</a><br>";	}	else 	{		echo "<h2>Error updating password</h2><br>";		echo "<a href=\"index.php?content=usersettings\">User Settings</a><br>";	}}}//"if (is set)" closing bracket}else{include('warninglogin.inc.php');}?></td></tr></table></center>