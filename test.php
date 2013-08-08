<?php 
include 'productionConnection.php';
$sql = "SELECT * 
		FROM __connection_log 
		WHERE timestamp >= '2013-08-07' 
		LIMIT 100";
$error_count = 0;

while ($row = mysql_fetch_array($result))
{
	$error_count++;
}
echo $error_count;
?>
