<?php
/**
 * This holds all of the sql functions that are used in the campaign
 * manager program.
 *
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @package    	Campaign Manager
 * @author 		Josh Stevens <joshua.stevens@avimark.net>
 * @copyright  	2013 Henry Schein AVImark
 * @version    	0.0.1
 * @name		functions.php
 */

include 'developmentConnection.php';

function getFullName($email)
{
	$sql = "SELECT id,firstName,lastName FROM user where email = '$email' ";
	$result = mysql_query($sql) or die('Could not find member: ' . mysql_error());
	while (($row = mysql_fetch_assoc($result)))
	{
		$firstName = $row['firstName'];
		$lastName = $row['lastName'];
	}

	mysql_close();

	$fullname = $firstName . ' ' . $lastName;
	return $fullname;

}


function getGroupId($email)
{
	$sql = "SELECT groupId FROM user where email = '$email' ";
	$result = mysql_query($sql);
	while (($row = mysql_fetch_assoc($result)))
	{
		$gid = $row['groupId'];
	}

	return $gid;
	mysql_close();
}

function getUserId($email)
{
	$sql = "SELECT DISTINCT id FROM user where email = '$email' ";
	$result = mysql_query($sql);
	while (($row = mysql_fetch_assoc($result)))
	{
		$id = $row['id'];
	}

	return $id;
	mysql_close();
}

function checkEmail($email, $password)
{
	$sql = "SELECT COUNT(*) from user where email = '$email'";
	$str = md5($password);

	$result = mysql_query($sql) or die('Could not find member: ' . mysql_error());
	if (!mysql_result($result, 0, 0) > 0)
	{
		return false;
	}

	$sql = "SELECT * FROM user WHERE email = '$email' AND password = '$str' and (groupId = '1' OR groupId = '2') 
	AND (id IN(879042,862032,817,878121,879047,879048,399627,275356))";
	$result = mysql_query($sql) or die('Could not find member: ');
	if (!mysql_result($result, 0, 0) > 0)
	{
		return false;
	}
	else
	{
		return true;
	}
}

function contactType($contactType)
{
	if ($contactType = 1)
		$newcontact = 'EMAIL';
	if ($contactType = 2)
		$newcontact = 'SMS';
	if ($contactType = 3)
		$newcontact = 'PHONE';
	if ($contactType = 4)
		$newcontact = 'EMAIL';

	return $newcontact;
}

function messageType($message)
{
	if ($message == '1')
	{
		$newType = 'GENERIC';
	}
	if ($message == '2')
	{
		$newType = 'APPOINTMENT';
	}
	if ($message == '3')
	{
		$newType = 'REMINDER';
	}
	if ($message == '4')
	{
		$newType = 'REMINDER OVERDUE';
	}
	if ($message == '5')
	{
		$newType = 'NEWSLETTER';
	}
	if ($message == '6')
	{
		$newType = 'CONTACT US';
	}
	if ($message == '7')
	{
		$newType = 'APPOINTMENT REQUEST';
	}
	if ($message == '8')
	{
		$newType = 'BOARDING REQUEST';
	}
	if ($message == '9')
	{
		$newType = 'REFILL REQUEST';
	}
	if ($message == '10')
	{
		$newType = 'CUSTOM_FORM';
	}
	if ($message == '11')
	{
		$newType = 'BIRTHDAY';
	}
	if ($message == '12')
	{
		$newType = 'ACCOUNT CREATED';
	}

	return $newType;
}

function getClinicName($dsid)
{
	$sql = "select name from clinic where dsid = '$dsid' ";

	$result = mysql_query($sql);
	while (($row = mysql_fetch_assoc($result)))
	{
		$clinicName = $row['name'];
	}

	return $clinicName;
	mysql_close();
}

function getClinicRid($dsid, $name)
{

	$sql = "SELECT * FROM clinic where dsid = '$dsid' AND name = '$name'";
	$result = mysql_query($sql) or die(mysql_error());
	while (($row = mysql_fetch_assoc($result)))
	{
		$rid = $row['rid'];
	}
	return $rid;
	mysql_close();
}

function emailIsValid($email)
{
	$sql = "SELECT COUNT(*) FROM user where email = '$email' ";
	$result = mysql_query($sql) or die('Could not find member: ' . mysql_error());
	if (!mysql_result($result, 0, 0) > 0)
	{
		return true;
	}
	else
	{
		echo '<h2>This email is already in use</h2><br>';
		return false;
	}
	mysql_close();
}

function toArray($obj)
{
	if (is_object($obj))
		$obj = (array)$obj;

	if (is_array($obj))
	{
		$new = array();

		foreach ($obj as $key => $val)
		{
			$new[$key] = toArray($val);
		}
	}
	else
	{
		$new = $obj;
	}
	return $new;
}

function getCompanyId($dsid)
{
	$sql = "SELECT * FROM data_source WHERE id = '$dsid'";
	$result = mysql_query($sql) or die(mysql_error());
	while (($row = mysql_fetch_assoc($result)))
	{
		$companyId = $row['companyId'];
	}

	return $companyId;
}
?>