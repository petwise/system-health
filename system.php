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

include ("header.php");
?>
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