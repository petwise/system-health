<?php
include 'developmentConnection.php';
include 'functions.php';

//start session
session_start();
// generate session id
session_regenerate_id();
// if there is no valid session

// define user
//$user = $_SESSION['user'];

// get the user information
//$id = getUserId($user);
// set count to 0
//$fullname = getFullName($user);
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

		<title>Stats</title>
	</head>
	<body class="metrouicss" onload="prettyPrint()">
		<div class="page2">
			<div class="nav-bar">
				<div class="nav-bar-inner padding10">
					<span class="pull-menu"></span>

					<a href="home.php"><span class="element brand"><i class="icon-accessibility-2"></i>Revenue Stats</span></a>

					<div class="divider"></div>
					<?
					echo "<ul class=\"menu\">";
					echo "<li><a href=\"system.php\"><span class=\"icon\"><i class=\"icon-home\"></i></span>Home</a></li>";
					echo "<li style=\"float:right;\"><a href=\"logout.php\"><span class=\"icon\"><i class=\"icon-cancel\"></i></span>Log Out</a></li>";
					//echo "<li style=\"float:right;\"><a href=\"#\"><span class=\"icon\"><i
					// class=\"icon-user\"></i></span>$fullname</a></li>";
					echo "</ul>";
					?>
				</div>
			</div>
		</div>
		<div class="page2" id="page-index">
			<div class="page">
				<div class="page-header">
					<div class="page-header-content">
						<h1>Revenue Stats<small></small></h1>
					</div>
				</div>
				<div class="page-region">
					<div class="page-region-content">
						<br>
						<?php
						include 'prodFunctions.php';

						echo "<p><b>Stats - for last 30 days</b></p>";
						echo "<table class=\"bordered striped\"><thead>";

						$titles = array(
							'Type',
							'Number of Visits',
							'Total Income',
							'Revenue per Visit'
						);
						foreach ($titles as $key => $value)
						{
							echo "<th>" . $value . "</th>";
						}
						echo "</thead><tbody>";
						$canine = perVisit(1092, 'canine', '30');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . $row['species'] . "</td>";
							echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</td>";
							echo "<td>" . '$ ' . round($row['per_visit'], 2) . "</td>";
							echo "</tr>";
						}

						$canine = perVisit(1092, 'feline', '30');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . $row['species'] . "</td>";
							echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') . "</td>";
							echo "</tr>";
						}

						$canine = perVisitOther(1092, '30');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . 'other' . "</td>";
							echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') . "</td>";
							echo "</tr>";
						}

						$canine = perVisitTotal(1092, '30');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . '<b>TOTALS</b>' . "</td>";
							echo "<td><b>" . number_format($row['number_records'], 0, '.', ',') . "</b></td>";
							echo "<td><b>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</b></td>";
							echo "<td><b>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') . "</b></td>";
							echo "</tr>";
						}
						echo "</tbody><tfoot></tfoot></table>";

						echo "<p><b>Stats - for last 90 days</b></p>";
						echo "<table class=\"bordered striped\"><thead>";

						$titles = array(
							'Type',
							'Number of Visits',
							'Total Income',
							'Revenue per Visit'
						);
						foreach ($titles as $key => $value)
						{
							echo "<th>" . $value . "</th>";
						}
						echo "</thead><tbody>";
						$canine = perVisit(1092, 'canine', '90');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . $row['species'] . "</td>";
							echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</td>";
							echo "<td>" . '$ ' . round($row['per_visit'], 2) . "</td>";
							echo "</tr>";
						}

						$canine = perVisit(1092, 'feline', '90');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . $row['species'] . "</td>";
							echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') . "</td>";
							echo "</tr>";
						}

						$canine = perVisitOther(1092, '90');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . 'other' . "</td>";
							echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') . "</td>";
							echo "</tr>";
						}

						$canine = perVisitTotal(1092, '90');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . '<b>TOTALS</b>' . "</td>";
							echo "<td><b>" . number_format($row['number_records'], 0, '.', ',') . "</b></td>";
							echo "<td><b>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</b></td>";
							echo "<td><b>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') . "</b></td>";
							echo "</tr>";
						}
						echo "</tbody><tfoot></tfoot></table>";

						echo "<p><b>Stats - for last 180 days</b></p>";
						echo "<table class=\"bordered striped\"><thead>";

						$titles = array(
							'Type',
							'Number of Visits',
							'Total Income',
							'Revenue per Visit'
						);
						foreach ($titles as $key => $value)
						{
							echo "<th>" . $value . "</th>";
						}
						echo "</thead><tbody>";
						$canine = perVisit(1092, 'canine', '180');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . $row['species'] . "</td>";
							echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</td>";
							echo "<td>" . '$ ' . round($row['per_visit'], 2) . "</td>";
							echo "</tr>";
						}

						$canine = perVisit(1092, 'feline', '180');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . $row['species'] . "</td>";
							echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') . "</td>";
							echo "</tr>";
						}

						$canine = perVisitOther(1092, '180');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . 'other' . "</td>";
							echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') . "</td>";
							echo "</tr>";
						}

						$canine = perVisitTotal(1092, '180');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . '<b>TOTALS</b>' . "</td>";
							echo "<td><b>" . number_format($row['number_records'], 0, '.', ',') . "</b></td>";
							echo "<td><b>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</b></td>";
							echo "<td><b>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') . "</b></td>";
							echo "</tr>";
						}
						echo "</tbody><tfoot></tfoot></table>";

						echo "<p><b>Stats - for last 365 days</b></p>";
						echo "<table class=\"bordered striped\"><thead>";

						$titles = array(
							'Type',
							'Number of Visits',
							'Total Income',
							'Revenue per Visit'
						);
						foreach ($titles as $key => $value)
						{
							echo "<th>" . $value . "</th>";
						}
						echo "</thead><tbody>";
						$canine = perVisit(1092, 'canine', '365');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . $row['species'] . "</td>";
							echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</td>";
							echo "<td>" . '$ ' . round($row['per_visit'], 2) . "</td>";
							echo "</tr>";
						}

						$canine = perVisit(1092, 'feline', '365');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . $row['species'] . "</td>";
							echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') . "</td>";
							echo "</tr>";
						}

						$canine = perVisitOther(1092, '365');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . 'other' . "</td>";
							echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</td>";
							echo "<td>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') . "</td>";
							echo "</tr>";
						}

						$canine = perVisitTotal(1092, '365');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . '<b>TOTALS</b>' . "</td>";
							echo "<td><b>" . number_format($row['number_records'], 0, '.', ',') . "</b></td>";
							echo "<td><b>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') . "</b></td>";
							echo "<td><b>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') . "</b></td>";
							echo "</tr>";
						}
						echo "</tbody><tfoot></tfoot></table>";

						/*	Stats for appointments
						 *
						 *
						 *
						 *
						 */
						echo "<p><b>Stats - Appointments Prior to Campaigns</b></p>";
						echo "<table class=\"bordered striped\"><thead>";

						$titles = array(
							'Type',
							'Number of Visits'
						);
						foreach ($titles as $key => $value)
						{
							echo "<th>" . $value . "</th>";
						}
						echo "</thead><tbody>";
						$canine = felineAppt(1092, '30', 'feline');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . 'Feline' . "</td>";
							echo "<td>" . $row['total'] . "</td>";
							echo "</tr>";
						}

						$canine = felineAppt(1092, '30', 'canine');
						$result = mysql_query($canine);
						while (($row = mysql_fetch_assoc($result)))
						{
							echo "<tr>";
							echo "<td>" . 'Canine' . "</td>";
							echo "<td>" . $row['total'] . "</td>";
							echo "</tr>";
						}

						/*$canine = perVisitOther(1092, '365');
						 $result = mysql_query($canine);
						 while(($row = mysql_fetch_assoc($result)))
						 {
						 echo "<tr>";
						 echo "<td>" . 'other' . "</td>";
						 echo "<td>" . number_format($row['number_records'], 0, '.', ',') . "</td>";
						 echo "<td>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') .
						 "</td>";
						 echo "<td>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',') .
						 "</td>";
						 echo "</tr>";
						 }

						 $canine = perVisitTotal(1092, '365');
						 $result = mysql_query($canine);
						 while(($row = mysql_fetch_assoc($result)))
						 {
						 echo "<tr>";
						 echo "<td>" . '<b>TOTALS</b>' . "</td>";
						 echo "<td><b>" . number_format($row['number_records'], 0, '.', ',') .
						 "</b></td>";
						 echo "<td><b>" . '$ ' . number_format(round($row['total'], 2), 2, '.', ',') .
						 "</b></td>";
						 echo "<td><b>" . '$ ' . number_format(round($row['per_visit'], 2), 2, '.', ',')
						 . "</b></td>";
						 echo "</tr>";
						 }*/
						echo "</tbody><tfoot></tfoot></table>";
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
		include ("footer.php");
		?>
