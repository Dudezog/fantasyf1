<!DOCTYPE html>

<?php
	//Connect to database
	include('f1_db.inc.php');
	
?>

<html>
	<head>
		<title>
			Fantasy F1
		</title>
		
		<link rel="stylesheet" type="text/css" href="master.css" />
	</head>

	<body>
		<?php
			include('header.inc.php');
		?>
	
	
		<?php
			if(!isset($_REQUEST['content']))
			{
				//If cookie set, redirect to members page, else show default page
				if(isset($_COOKIE['userID']))
				{
					echo "<h1>Loading...</h1>";
					echo "<script> location.replace(\"index.php?content=dash\"); </script>";
				}
				else
				{
					include('main.inc.php');
				}
				
			}
			else
			{
				$content = $_REQUEST['content'];
				$nextpage = $content . ".inc.php";
                include($nextpage);
			}		
		?>
		
		<?php
			include('footer.inc.php');
		?>
	
	</body>
</html>

