<?php
$servername = "explorer-server.mysql.database.azure.com";
$username = "xdifhddbhh";
$password = "w8J523yFSqAcI5X$";
$dbname = "divinedb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Indicate, Activity, Quiz, Exam, Answer FROM Content";
$res = $conn->query($sql);

// Check if rows is more than one
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        // Formatted data
        echo $row["Indicate"] . "|" . $row["Activity"] . "|" . $row["Quiz"] . "|" . $row["Exam"] . "|" . $row["Answer"] . "\n";
    }
} else {
    echo "0 results";
}



$conn->close()
?>