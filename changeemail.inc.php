<center><table border="0" cellpadding="3" cellspacing="10" bgcolor="#FFFFFF"><tr><td><?php//Make sure user is logged in before doing anythingif(isset($_COOKIE['userID'])){$userid = $_COOKIE['userID'];$email = $_POST['email'];$email2 = $_POST['email2'];$baduser = 0; if (get_magic_quotes_gpc())	{      $email = stripslashes($email);	  $email2 = stripslashes($email2);	}//Check if email was enteredif (trim($email) == '')	{		echo "<h2>Sorry, you did not enter a new E-mail.</h2><br>\n";		echo "<a href=\"index.php?content=usersettings\">Try again</a><br>\n";		$baduser = 1;	}if (trim($email2) == '')	{		echo "<h2>Sorry, you did not confirm new E-mail.</h2><br>\n";		echo "<a href=\"index.php?content=usersettings\">Try again</a><br>\n";		$baduser = 1;	}//Check if new emails matchif ($email != $email2)	{		echo "<h2>Sorry, your E-mails did not match.</h2><br>\n";		echo "<a href=\"index.php?content=usersettings\">Try again</a><br>\n";		$baduser = 1;	}//Check if e-mail is already in database//Prepare the statement if(!($query = $con->prepare("SELECT UserID from users WHERE Email = ?"))) {    echo "Prepare failed: (" . $con->errno . ") " . $con->error; }	$query->bindValue(1, $email, PDO::PARAM_STR);	$query->execute();	//Check if email is already registered	$row_count = $query->rowCount();	if ($row_count != 0)	{		echo "<h2>Sorry, that E-mail is already registered with an account.</h2><br>\n";		echo "<a href=\"index.php?content=usersettings\">Try again</a><br>\n";		$baduser = 1;	}	if ($baduser != 1)	{	$query = $con->prepare("UPDATE users set Email= ? WHERE UserID=?");	$query->bindValue(1, $email, PDO::PARAM_STR);	$query->bindValue(2, $userid, PDO::PARAM_STR);	$result = $query->execute();	if($result)	{		echo "<h2>E-mail updated!</h2><br>";		echo "<a href=\"index.php?content=usersettings\">User Settings</a><br>";	}	else 	{		echo "<h2>Error updating E-mail</h2><br>";		echo "<a href=\"index.php?content=usersettings\">User Settings</a><br>";	}}//"if (is set)" closing bracket}else{include('warninglogin.inc.php');}?></td></tr></table></center>