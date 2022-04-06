<?php

// $serverName = "libraryprojserv.mysql.database.azure.com"; //localhost
// $dBUsername = "adminuser"; //root
// $dBPassword = "22TYRRL8A8V31810$";
// $dBName = "library";

// $conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

// if (!$conn) {
//    die("Connection failed: ".mysqli_connect_error()); 
// }

$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($con, "libraryprojserv.mysql.database.azure.com", "adminuser", "22TYRRL8A8V31810$", "library", 3306, MYSQLI_CLIENT_SSL);

// if (!$conn) {
//    die("Connection failed: ".mysqli_connect_error()); 
// }

?>