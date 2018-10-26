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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	</head>

	<body>
	<div id="wrapper">
		<div id="header">
			<?php
				include('header.inc.php');
			?>
		</div><!-- header div -->
	
		<div id="content">
			<?php
				if(!isset($_REQUEST['content']))
				{
					//If cookie set, redirect to members page, else show default page
					if(isset($_COOKIE['userID']))
					{
						echo "<h1>Loading...</h1>";
						echo "<script> location.replace(\"index.php?content=my_leagues\"); </script>";
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
		</div><!-- content div -->
		
		<div id="footer">
			<?php
				include('footer.inc.php');
			?>
		</div><!-- footer div -->	
		
	</div><!-- wrapper div -->
	</body>
</html>

