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

include ("header.php");
?>
<div class="page2" id="page-index">
	<div class="page">
		<div class="page-header">
			<div class="page-header-content">
				<h1>System Health Check<small> production systems</small></h1>
			</div>
		</div>
		<div class="page-region">
			<div class="page-region-content"><br>
				<?php
if(isset($_POST['submit']))
{
echo "<meta http-equiv=\"refresh\" content=\"3;url=index.php\">";
}
else
{
		include 'prodFunctions.php';
		$todayTotal = vetLogicConnectionToday();
		$weeklyTotal = vetLogicConnectionWeekly();
		$percent = ($todayTotal / $weeklyTotal);
		$finalPercent = substr($percent, 2, 2);
		
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
		echo "<table class=\"bordered striped\"><thead><tr><th>Type</th><th>Queued</th><th>Sent</th></tr></thead><tbody>";
		echo '<tr><td>Appointment</td><td>' . messageTypeQueued(2, 1, 1) . '</td><td>' . messageTypeSent(2, 1, 1) . '</td></tr>';
		echo '<tr><td>Reminders</td><td>' . messageTypeQueued(3, 1, 1) . '</td><td>' . messageTypeSent(3, 1, 1) . '</td></tr>';
		echo '<tr><td>Newsletter</td><td>' . messageTypeQueued(5, 1, 1) . '</td><td>' . messageTypeSent(5, 1, 1) . '</td></tr>';				
		echo '<tr><td>Birthday</td><td>' . messageTypeQueued(11, 1, 1) . '</td><td>' . messageTypeSent(11, 1, 1) . '</td></tr>';
		echo '<tr><td>Account Created</td><td>' . messageTypeQueued(12, 1, 1) . '</td><td>' . messageTypeSent(12, 1, 1) . '</td></tr>';
		echo '<tr><td>Failure Warning</td><td>' . messageFailureQueued() . '</td><td>' . messageFailureSent() . '</td></tr>';
		echo "</tbody><tfoot></tfoot></table>";
	
	
		echo "<p><b>eMinders Message Stats</b></p>";
		echo "<table class=\"bordered striped\"><thead><tr><th>Type</th><th>Queued</th><th>Sent</th></tr></thead><tbody>";
		echo '<tr><td>Email</td><td>' . messageTypeQueued2(2, 1) . '</td><td>' . messageTypeSent2(2, 1) . '</td></tr>';
		echo '<tr><td>SMS</td><td>' . messageTypeQueued2(2, 2) . '</td><td>' . messageTypeSent2(2, 2) . '</td></tr>';
		echo '<tr><td>Voice</td><td>' . messageTypeQueued2(2, 3) . '</td><td>' . messageTypeSent2(2, 3) . '</td></tr>';
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
