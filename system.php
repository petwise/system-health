<?php
include ("developmentConnection.php");
include ("functions.php");
//start session
session_start();
// generate session id
session_regenerate_id();
// if there is no valid session
if (!isset($_SESSION['user']))
{
	header("Location: index.php");
}
// define user
$user = $_SESSION['user'];

// get the user information
$id = getUserId($user);
// set count to 0
$fullname = getFullName($user);
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
<div class="page2" id="page-index">
	<div class="page">
		<div class="page-header">
			<div class="page-header-content">
				<h1>System Health Check<small> Chose Which System</small></h1>
			</div>
		</div>
		<div class="page-region">
			<div class="page-region-content">
				<?php
				if(isset($_POST['submit']))
				{
				echo "<meta http-equiv=\"refresh\" content=\"3;url=home.php\">";
				}
				else
				{

				?>
				<div class="span12">
					<div class="row">
						<div class="span10 offset2">
							<button class="standart default bg-color-green" onclick="document.location.href='http://systemHealth.dev/dev.php'">
								Development System
							</button>
							<button class="standart default bg-color-green" onclick="document.location.href='http://systemHealth.dev/prod.php'">
								Production System
							</button>
						</div>
					</div>
				</div>
			<?php } ?>
				
			</div>
		</div>
	</div>
</div>

<?php
include ("footer.php");
?>