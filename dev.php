<?php
include 'developmentConnection.php';
include 'functions.php';

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
					if (isset($_SESSION['user']))
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
						<h1>System Health Check<small> development systems</small></h1>
						<p>Our message system is currently <b>OFF</b> for the development environment. We only send out messages to test email accounts, therefore, the message check will always show up red. </p>
					</div>
				</div>
				<div class="page-region">
					<div class="page-region-content">
						<br>
						<?php
						if (isset($_POST['submit']))
						{
							echo "<meta http-equiv=\"refresh\" content=\"3;url=index.php\">";
						}
						else
						{
							include 'devFunctions.php';
							$todayTotal = vetLogicConnectionToday();
							$weeklyTotal = vetLogicConnectionWeekly();
							$percent = ($todayTotal / 2);
							$finalPercent = substr($percent, 0, 1);
							$finalPercent = $finalPercent . '00';

							echo "<p><b>System Health Stats</b></p>";
							echo "<table class=\"bordered striped\"><thead><tr><th>Health</th><th>Operation</th><th>Description</th><th>Connection %</th></tr></thead><tbody>";
							echo '<tr><td><img src="images/green.png" height="16px" width="16px"/></td><td>Inmotion Server Connection</td><td>websites are hosted here</td><td></td></tr>';
							echo '<tr><td><img src="images/green.png" height="16px" width="16px"/></td><td>Elastic Email Connection</td><td>all of our messaging is sent through this service</td><td></td></tr>';

							if (checkConnection())
							{
								echo '<tr><td><img src="images/green.png" height="16px" width="16px"/></td><td>Rackspace Database Connection</td><td>vetlogic database</td><td></td></tr>';
								echo '<tr><td><img src="images/green.png" height="16px" width="16px"/></td><td>Avimark Sync / Vetlogic Client</td><td>syncs data from AVImark databases to the vetlogic database
			</td><td><b>' . $finalPercent . '%</b></td></tr>';
							}
							else
							{
								echo '<tr><td><img src="images/red.png" height="16px" width="16px"/></td><td>Rackspace Database Connection</td><td>vetlogic database</td><td></td></tr>';
								echo '<tr><td><img src="images/red.png" height="16px" width="16px"/></td><td>Avimark Sync / Vetlogic Client</td><td>syncs data from AVImark databases to the vetlogic database
			</td><td><b>' . $finalPercent . '%</b></td></tr>';
							}

							if (!checkProdSystem())
							{
								echo '<tr><td><img src="images/red.png" height="16px" width="16px"/></td><td>Messages</td><td>reminders, appointments, birthday, newsletters, one-off, form submissions</td><td></td></tr>';
							}
							else
							{
								echo '<tr><td><img src="images/green.png" height="16px" width="16px"/></td><td>Messages</td><td>reminders, appointments, birthday, newsletters, one-off, form submissions</td><td></td></tr>';
							}
							echo "</tbody><tfoot></tfoot></table>";

							echo "<p><b>Petwise Message Stats</b></p>";
							echo "<table class=\"bordered striped\"><thead>";

							$titles = array(
								'Message Type',
								'Queued',
								'Sent'
							);
							foreach ($titles as $key => $value)
							{
								echo "<th>" . $value . "</th>";
							}
							echo "</thead><tbody>";
							$sql = petwiseQuery();
							$result = mysql_query($sql);
							while (($row = mysql_fetch_assoc($result)))
							{
								echo "<tr>";
								echo "<td>" . $row['messageType'] . "</td>";
								echo "<td>" . $row['queued'] . "</td>";
								echo "<td>" . $row['sent'] . "</td>";
								echo "</tr>";
							}
							echo "</tbody><tfoot></tfoot></table>";

							echo "<p><b>eMinders Message Stats</b></p>";
							echo "<table class=\"bordered striped\"><thead>";
							foreach ($titles as $key => $value)
							{
								echo "<th>" . $value . "</th>";
							}
							echo "</thead><tbody>";
							$sql = emindersQuery();
							$result = mysql_query($sql);
							while (($row = mysql_fetch_assoc($result)))
							{
								echo "<tr>";
								echo "<td>" . $row['messageType'] . "</td>";
								echo "<td>" . $row['queued'] . "</td>";
								echo "<td>" . $row['sent'] . "</td>";
								echo "</tr>";
							}
							echo "</tbody><tfoot></tfoot></table>";
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
		include ("footer.php");
		?>
