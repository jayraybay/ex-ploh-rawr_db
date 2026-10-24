<?php
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL, "/DigiCertGlobalRootG2.crt.pem", NULL, NULL);

$host = "explorer-server.mysql.database.azure.com"; 
$username = "xdifhddbhh";
$password = "w8J523yFSqAcI5X$";
$db_name = "divinedb";
$port = 3306;

mysqli_real_connect($conn, $host, $username, $password, $db_name, $port, MYSQLI_CLIENT_SSL);
if (mysqli_connect_errno()) {
    die("Connection failed: " . $conn->connect_error);
}


echo "Successfully connected to Azure MySQL using MySQLi.";

$retrieve_result = $conn->query("SELECT * FROM Student");
?>


<!DOCTYPE HTML>
<html>
<link rel="stylesheet" href="admin_home.css" />

<head><h1>Student Account Monitoring</h1></head>
<table>
    <thead>
        <tr>
            <th class="name">username</th>
            <th class="Sname">Name</th>
            <th class="pass">School ID</th>
            <th class="sel">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if ($retrieve_result->num_rows > 0) {
                while ($row = $retrieve_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["PlayerName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["PlayerName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["ID"]) . "</td>";
                    echo "<td>" . "Offline" . "</td>";
                    echo "</tr>";
                }

            } else {
                echo "<tr><td colspan='4'>No records found</td></tr>";

            }


        ?>

        <tr>
            <td>Username#1</td>
            <td>Student Name</td>
            <td>School ID</td>
            <td>Active</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Username#2</td>
            <td>Student Name</td>
            <td>School ID</td>
            <td>Offline</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Username#3</td>
            <td>Student Name</td>
            <td>School ID</td>
            <td>Active</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Username#4</td>
            <td>Student Name</td>
            <td>School ID</td>
            <td>Active</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Username#5</td>
            <td>Student Name</td>
            <td>School ID</td>
            <td>Active</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Username#6</td>
            <td>Student Name</td>
            <td>School ID</td>
            <td>Active</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Username#7</td>
            <td>Student Name</td>
            <td>School ID</td>
            <td>Offline</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>Username#8</td>
            <td>Student Name</td>
            <td>School ID</td>
            <td>Offline</td>
        </tr>
    </tbody>
</table>

<div class="search">
    <input type="text" placeholder="Please enter name" required />
</div>

</html>