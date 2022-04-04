<?php

$serverName = "libraryprojserv.mysql.database.azure.com"; //localhost
$dBUsername = "adminuser"; //root
$dBPassword = "22TYRRL8A8V31810$ "; /""
$dBName = "libraryprojserv";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
   die("Connection failed: " . mysqli_connect_error()); 
}

?>