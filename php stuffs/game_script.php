<?php
// This is example of how to do PHP stuffs, copy the boilerplate code to get target
// <Boilerplate>
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "divinedb";

// Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);
$user = "";

if ($conn->connect_error) { // connection failed
    //echo "Connection Failed"
    die("Connection failed: " . $conn->connect_error);
}
// </Boilerplate>

// SImple example capturing data sent from Unity
if (isset($_POST["username"])) {
    $user = $_POST["username"];
    echo "Success! Hello " . $user;
}
?>