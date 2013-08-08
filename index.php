<?php
include 'developmentConnection.php';
include("functions.php");



if(isset($_POST['submit']))
{
	$error_no = 0;

	if($_POST['email'] == '')
	{
		echo '<h2>Please Fill in Email.</h2><br>';
		$error_no++;
	}

	if($_POST['password'] == '')
	{
		echo '<h2>Please enter a password</h2><br>';
	}

	if(@checkEmail($_POST['email'], $_POST['password']))
	{
		Session_start ();
		if( isset($_POST['email']) && isset($_POST['password']) )
		{
			$_SESSION['user'] = $_POST['email'];
			header("Location: system.php");
			ob_end_flush();
		}
		else
		{
			header( "Location: index.php" );
		}

	}
	else 
	{
		ECHO '<h2>Email or Password is Incorrect!</h2><br>';
		?>
		<meta http-equiv="refresh" content="3;url=index.php">
		<?
	}
}
else
{
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="description" content="Metro UI CSS">
    <meta name="author" content="Sergey Pimenov">
    <meta name="keywords" content="windows 8, modern style, Metro UI, style, modern, css, framework">

    <link href="css/modern.css" rel="stylesheet">
    <link href="css/modern-responsive.css" rel="stylesheet">
    <link href="css/site.css" rel="stylesheet" type="text/css">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/styling.css" type="text/css">
    <link rel="stylesheet" href="css/zebra_pagination.css" type="text/css">

    <script type="text/javascript" src="js/assets/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="js/assets/jquery.mousewheel.min.js"></script>
    <script type="text/javascript" src="js/assets/moment.js"></script>
    <script type="text/javascript" src="js/assets/moment_langs.js"></script>

    <script type="text/javascript" src="js/modern/dropdown.js"></script>
    <script type="text/javascript" src="js/modern/accordion.js"></script>
    <script type="text/javascript" src="js/modern/buttonset.js"></script>
    <script type="text/javascript" src="js/modern/carousel.js"></script>
    <script type="text/javascript" src="js/modern/input-control.js"></script>
    <script type="text/javascript" src="js/modern/pagecontrol.js"></script>
    <script type="text/javascript" src="js/modern/rating.js"></script>
    <script type="text/javascript" src="js/modern/slider.js"></script>
    <script type="text/javascript" src="js/modern/tile-slider.js"></script>
    <script type="text/javascript" src="js/modern/tile-drag.js"></script>
    <script type="text/javascript" src="js/modern/calendar.js"></script>

    <title>System Health Check</title>
</head>
<body class="metrouicss" onload="prettyPrint()">
<div class="page2">
	<div class="nav-bar">
		<div class="nav-bar-inner padding10">
			<span class="pull-menu"></span>

			<a href="home.php"><span class="element brand"><i class="icon-accessibility-2"></i>System Health Check</span></a>

			<div class="divider"></div>
			<?
				if(isset($_SESSION['user']))
				{
					echo "<ul class=\"menu\">";
					echo "<li><a href=\"system.php\"><span class=\"icon\"><i class=\"icon-home\"></i></span>Home</a></li>";
					echo "<li style=\"float:right;\"><a href=\"logout.php\"><span class=\"icon\"><i class=\"icon-cancel\"></i></span>Log Out</a></li>";
					echo "<li style=\"float:right;\"><a href=\"#\"><span class=\"icon\"><i class=\"icon-user\"></i></span>$fullname</a></li>";
					echo "</ul>";
				}
			?>
		</div>
	</div>
</div>
<?

	echo "<div class=\"page2\" id=\"page-index\">";
		echo "<div class=\"page\">";
			echo "<div class=\"page-header\">";
				echo "<div class=\"page-header-content\">";
					echo "<h1>MSS Systems Health Check</h1>";
				echo "</div>";
			echo "</div>";
			echo "<div class=\"page-region\">";
				echo "<div class=\"page-region-content\">";
					echo "<div class=\"span4 offset3\">";
						echo "<h2>Email Address:</h2>";
						echo "<form action=\"index.php\" method=\"POST\">";
							echo "<div class=\"input-control text\">";
								echo "<input type=\"text\" name=\"email\" placeholder=\"Enter your email address\"/>";
								echo "<button class=\"btn-clear\" />";
							echo "</div><br>";
							echo "<h2>Password:</h2>";
							echo "<div class=\"input-control password\">";
								echo "<input type=\"password\" name=\"password\" placeholder=\"Enter your password\" />";
								echo "<button class=\"btn-reveal\"></button>";
							echo "</div><br>";
							echo "<input type=\"submit\" value=\"Submit\" name=\"submit\">";
						echo "</form>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
	include ("footer.php");
	
}
mysql_close();
?>
