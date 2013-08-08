<?
include ("functions.php");
if(isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
	$status = getGroupId($user);
	$fullname = getFullName($user);
}
?>

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
					echo "<li><a href=\"home.php\"><span class=\"icon\"><i class=\"icon-home\"></i></span>Home</a></li>";
					echo "<li style=\"float:right;\"><a href=\"logout.php\"><span class=\"icon\"><i class=\"icon-cancel\"></i></span>Log Out</a></li>";
					echo "<li style=\"float:right;\"><a href=\"#\"><span class=\"icon\"><i class=\"icon-user\"></i></span>$fullname</a></li>";
					echo "</ul>";
				}
			?>
		</div>
	</div>
</div>
