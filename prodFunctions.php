<?php
include 'productionConnection.php';

function vetLogicConnectionWeekly()
{

	$format = 'Y-m-d';
	$dt = date($format);
	$sevendays = date($format, strtotime('-7 days' . $dt));
	$sql = "SELECT COUNT(DISTINCT(dsid)) AS total_count from __connection_log where connected = 1 and timestamp >= '$sevendays' limit 1";
	$result = mysql_query($sql) or die('Connection Error: ' . mysql_error());
	//$result = mysql_result($result,0);
	//echo mysql_fetch_assoc($result);
	while (($row = mysql_fetch_assoc($result)))
	{
		$sevenDayTotal = $row['total_count'];
	}
	return $sevenDayTotal;
	mysql_close();
}

function vetLogicConnectionToday()
{
	$dt = date('Y-m-d');
	$sql = "SELECT COUNT(DISTINCT (dsid)) from __connection_log where connected = 1 and timestamp >= '$dt' limit 3500";
	$result = mysql_query($sql) or die('Connection Error: ' . mysql_error());
	while (($row = mysql_fetch_assoc($result)))
	{
		$todayTotal = $row['COUNT(DISTINCT (dsid))'];
	}
	return $todayTotal;
	mysql_close();
}

function checkConnection()
{
	$sql = "SELECT COUNT(id) from message";
	$result = mysql_query($sql) or die('Could not connect to database: ' . mysql_error());
	if (!mysql_result($result, 0, 0) > 0)
	{
		return false;
	}
	else
	{
		return true;
	}
	mysql_close();
}

function getMailQuery()
{
	$sql = "
select
  msgtyp.name messageType,
  contct.name contactType,
  transp.name customerType,
  counts.queued AS queued,
  counts.sent AS sent
from
  message_transport transp
  join message_type msgtyp
  join contact_type contct
  left join (
    select
      contactTypeId,
      transportId,
      messageTypeId,
      count(queuedAt) queued,
      count(sentAt) sent
    from
      message 
    where
      queuedAt >= date(now())
      or sentAt >= date(now())
    group by
     contactTypeId, transportId, messageTypeId 
  ) counts on
    msgtyp.id = counts.messageTypeId 
	and contct.id = counts.contactTypeId 
	and transp.id = counts.transportId
where 
  (transp.id = 1 and contct.id=1) -- only email for petwise
  or (transp.id=2 and contct.id in (1,2,3)) -- skip contact type 4 not used
order by
  transp.id,
  msgtyp.id,
  contct.id;";

	return $sql;
}

/*
 *
 *
 * Petwise Message Type Functions.
 */

function messageTypeQueued($messageType, $transport, $contact)
{
	$dt = date('Y-m-d');
	$sql = "SELECT COUNT(id) AS newsCount from message where messageTypeId = '$messageType' AND transportId = '$transport' AND contactTypeId = '$contact' AND queuedAt >= '$dt' limit 10000";
	$result = mysql_query($sql) or die('Connection Error: ' . mysql_error());
	while (($row = mysql_fetch_assoc($result)))
	{
		$num = $row['newsCount'];
	}
	return $num;
	mysql_close();
}

function messageTypeSent($messageType, $transport, $contact)
{
	$dt = date('Y-m-d');
	$sql = "SELECT COUNT(id) AS reminderCount from message where messageTypeId = '$messageType' AND transportId = '$transport' AND contactTypeId = '$contact' AND sentAt IS NOT NULL AND is_processed = 1 AND queuedAt >= '$dt' limit 10000";
	$result = mysql_query($sql) or die('Connection Error: ' . mysql_error());
	while (($row = mysql_fetch_assoc($result)))
	{
		$num = $row['reminderCount'];
	}
	return $num;
	mysql_close();
}

function messageTypeQueued2($transport, $contact)
{
	$dt = date('Y-m-d');
	$sql = "SELECT COUNT(id) AS reminderCount from message where transportId = '$transport' AND contactTypeId = '$contact' AND queuedAt >= '$dt'";
	$result = mysql_query($sql) or die('Connection Error: ' . mysql_error());
	while (($row = mysql_fetch_assoc($result)))
	{
		$num = $row['reminderCount'];
	}
	return $num;
	mysql_close();
}

function messageTypeSent2($transport, $contact)
{
	$dt = date('Y-m-d');
	$sql = "SELECT COUNT(id) AS reminderCount from message where transportId = '$transport' AND contactTypeId = '$contact' AND sentAt IS NOT NULL AND queuedAt >= '$dt'";
	$result = mysql_query($sql) or die('Connection Error: ' . mysql_error());
	while (($row = mysql_fetch_assoc($result)))
	{
		$num = $row['reminderCount'];
	}
	return $num;
	mysql_close();
}

function messageFailureQueued()
{
	$dt = date('Y-m-d');
	$sql = "SELECT COUNT(id) AS num from message where priority = 110 AND queuedAt >= '$dt'";
	$result = mysql_query($sql) or die('Connection Error: ' . mysql_error());
	while (($row = mysql_fetch_assoc($result)))
	{
		$num = $row['num'];
	}
	return $num;
	mysql_close();
}

function messageFailureSent()
{
	$dt = date('Y-m-d');
	$sql = "SELECT COUNT(id) AS num from message where priority = 110 AND sentAt IS NOT NULL AND queuedAt >= '$dt'";
	$result = mysql_query($sql) or die('Connection Error: ' . mysql_error());
	while (($row = mysql_fetch_assoc($result)))
	{
		$num = $row['num'];
	}
	return $num;
	mysql_close();
}

function checkProdSystem()
{
	$file = 'prod.txt';
	$handle = fopen($file, "r+");
	$dt = date('Y-m-d');

	$sql = "SELECT COUNT(id) as value FROM message where queuedAt >= '$dt'";
	$row = mysql_fetch_assoc(mysql_query($sql));
	$todaysMessages = $row['value'];

	$valueFromFile = file_get_contents($file);
	if (!$valueFromFile)
	{

		fwrite($handle, $todaysMessages);
	}
	else
	{
		if ($valueFromFile <= $todaysMessages)
		{
			fwrite($handle, $valueFromFile);
			return true;
		}
		else
		{

			return false;
		}
	}
	fclose($handle);
	mysql_close();
}
