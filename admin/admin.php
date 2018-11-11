<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<! <link rel="stylesheet" type="text/css" href="adminstyle.css" /> 
<title>Fantasy F1 - Admin Console</title>
</head>

<?php
	//Connect to database
	include('f1_db.inc.php');
	//Get race date functions
	require_once('race_date_functions.inc.php');
?>

<body>
<table width="100%" border="0">
  <tr>
    <td id="header" height="90" colspan="3">
	<?php include("header.inc.php"); ?></td>
  </tr>
  <tr>
    <td id="nav" width="20%" valign="top">
	<?php include("adminnav.inc.php"); ?></td>
    <td id="main" width="50%" valign="top">
	  <?php
               if (!isset($_REQUEST['content']))
               {
                   if (!isset($_SESSION['f1_admin']))
                      include("adminlogin.html");
                   else
                      include("adminmain.inc.php");
               }
               else
               {
                   $content = $_REQUEST['content'];
                   $nextpage = $content . ".inc.php";
                   include($nextpage);
               } 
		?>
	</td>
  </tr>
  
  <tr>
    <td id="footer" colspan="3">
	  <div align="center">
	  <?php include("footer.inc.php"); ?>
	  </div></td>
  </tr>
</table>
</body>
</html>