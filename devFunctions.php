<?php
include 'developmentConnection.php';

function vetLogicConnectionWeekly()
{
	$sql = "SELECT COUNT(DISTINCT(dsid)) AS total_count from __connection_log where connected = 1 and timestamp <= NOW() AND timestamp >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
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
	$sql = "SELECT COUNT(DISTINCT (dsid)) from __connection_log where connected = 1 and timestamp >= Date(now())";
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
	return true;
	mysql_close();
}

function petwiseQuery()
{
	$sql = "
select
  mt.name AS 'messageType',
  count(queuedAt) queued,
  count(sentAt) sent
from
  message m
LEFT JOIN message_type mt
	ON m.messageTypeId = mt.id
LEFT JOIN contact_type ct
	ON ct.id = m.contactTypeId
LEFT JOIN message_transport tr
	ON tr.id = m.transportId
where
  queuedAt >= Date(now()) AND m.transportId = '1'
group by
  messageTypeId, contactTypeId";

	return $sql;
}

function emindersQuery()
{
	$sql = "select
CONCAT(mt.name, ' - ', ct.name) AS 'messageType',
  count(queuedAt) queued,
  count(sentAt) sent
from
  message m
LEFT JOIN message_type mt
	ON m.messageTypeId = mt.id
LEFT JOIN contact_type ct
	ON ct.id = m.contactTypeId
LEFT JOIN message_transport tr
	ON tr.id = m.transportId
where
  queuedAt >= Date(now()) AND m.transportId = '2'
group by
  messageTypeId, contactTypeId";

	return $sql;
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

function checkProdSystem()
{
	$file = 'dev.txt';
	$handle = fopen($file, "r+");

	$sql = "SELECT COUNT(id) as value FROM message where queuedAt >= Date(now())";
	$row = mysql_fetch_assoc(mysql_query($sql));
	$todaysMessages = $row['value'];

	$valueFromFile = file_get_contents($file);
	if (!$valueFromFile)
	{
		fwrite($handle, $todaysMessages);
		return true;
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
