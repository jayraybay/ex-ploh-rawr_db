<?php
$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, "{path to CA cert}", NULL, NULL);
mysqli_real_connect($conn, "explorer-server.mysql.database.azure.com", "xdifhddbhh", "w8J523yFSqAcI5X$", "divinedb", 3306, MYSQLI_CLIENT_SSL);

if ($con->connect_error) {
    echo "Connection Failed";
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST["id"];
$pwd = $_POST["pwd"];

/*
$get_creds = "SELECT `ID`, `Password`, `FName`, `MName`, `LName`, `Section` FROM Teacher WHERE " .
             "ID='" . $input_id . "' AND " .
             "Password='" . $input_pwd . "'";*/

echo "Test Success";


?>