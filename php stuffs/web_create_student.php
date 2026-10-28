<?php
$host = "localhost"; 
$username = "root";
$password = "";
$dbname = "divinedb";
$port = 3306;

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("". $conn->connect_error);
}

//$retrieve_sections = $conn->query("SELECT * FROM Section;");

?>