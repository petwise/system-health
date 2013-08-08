<?php
$host = "mcallister.servers.deltasys.com";
$username = "vetlogic_live";
$password = "?yW13F{*=?";
$db_name = "vetlogic_live";


$conn = mysql_connect("$host", "$username", "$password")or die("cannot connect to server");
mysql_select_db("$db_name")or die("cannot select db"); 
?>