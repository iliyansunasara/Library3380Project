<?php

// $serverName = "localhost";
// $dBUsername = "root";
// $dBPassword = "";
// $dBName = "library";

// $conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

// if (!$conn) {
//    die("Connection failed: " . mysqli_connect_error()); 
// }

$host = 'libraryprojserv.mysql.database.azure.com';
$username = 'adminuser';
$password = '22TYRRL8A8V31810$';
$db_name = 'library';

//Initializes MySQLi
$con = mysqli_init();
//$conn = mysqli_connect($host, $username, $password, $db_name);

// mysqli_ssl_set($conn,NULL,NULL, "/var/www/html/DigiCertGlobalRootG2.crt.pem", NULL, NULL);
mysqli_ssl_set($con,NULL,NULL, "/DigiCertGlobalRootCA.crt.pem", NULL, NULL);

// Establish the connection
mysqli_real_connect($conn, "libraryprojserv.mysql.database.azure.com", "adminuser", "22TYRRL8A8V31810$", "library", 3306, MYSQLI_CLIENT_SSL);

//If connection failed, show the error
if (mysqli_connect_errno())
{
    die('Failed to connect to MySQL: '.mysqli_connect_error());
}

?>