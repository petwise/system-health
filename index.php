<?php
include 'developmentConnection.php';
include("functions.php");



if(isset($_POST['submit']))
{
	$error_no = 0;

	if($_POST['email'] == '')
	{
		echo 'Please Fill in Email.';
		$error_no++;
	}

	if($_POST['password'] == '')
	{
		echo 'Please enter a password';
	}

	if(checkEmail($_POST['email'], $_POST['password']))
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
	else {
		ECHO 'Email or Password is Incorrect!';
	}
}
else
{
	include ("header.php");

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
