<?php

function getUserInfo($userID)
{
	//Connect to database
	include('f1_db.inc.php');

	$user = array("error"=>FALSE);
	
	$query = $con->prepare("SELECT * From users WHERE UserID = ?");
	$query->bindValue(1, $userID, PDO::PARAM_STR);
	$result = $query->execute();
	if($result)
	{
	 while($row = $query->fetch())
	  {
		$user['userID'] = $row['UserID'];
		$user['userName'] = $row['UserName'];
		$user['firstName'] = $row['FirstName'];
		$user['lastName'] = $row['LastName'];
		$user['email'] = $row['Email'];
	  }	
    }
  else
  {
	  $user['error'] = True;
  }
  
  return $user;
}

?>