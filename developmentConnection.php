<?php
$host="216.106.5.111";
$username="warren";
$password="mumbojumbo10";
$db_name="vetlogic_live";


$conn = mysql_connect("$host", "$username", "$password")or die("cannot connect to server");
mysql_select_db("$db_name")or die("cannot select db"); 
?>