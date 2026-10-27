<?php
$servername = "explorer-server.mysql.database.azure.com";
$username = "xdifhddbhh";
$password = "w8J523yFSqAcI5X$";
$dbname = "divinedb";

// Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);
$user = "";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SImple example capturing data sent from Unity
if (isset($_POST["username"])) {
    $user = $_POST["username"];
    echo "Success! Hello " . $user;
}
?>