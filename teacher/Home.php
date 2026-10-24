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

//$id = $_POST["id"];
//$pwd = $_POST["pwd"];

echo "Successfully connected to Azure MySQL using MySQLi.";

/*
$get_creds = "SELECT `ID`, `Password`, `FName`, `MName`, `LName` FROM Teacher WHERE " .
             "ID='" . $input_id . "' AND " .
             "Password='" . $input_pwd . "'";*/

$retrieve_result = "SELECT * FROM Student";
?>

<!DOCTYPE HTML>
<html>
<link rel="stylesheet" href="Home.css" />
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<body><table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Rank</th>
            <th>Progress</th>
            <th>Mastery</th>
        </tr>
    </thead>
    <tbody>
        <tr data-href="Students.html">
            <td>User1</td>
            <td>1st</td>
            <td>100%</td>
            <td>2.0</td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="Students.html">
            <td>User1</td>
            <td>1st</td>
            <td>100%</td>
            <td>2.0</td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="Students.html">
            <td>User1</td>
            <td>1st</td>
            <td>100%</td>
            <td>2.0</td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="Students.html">
            <td>User1</td>
            <td>1st</td>
            <td>100%</td>
            <td>2.0</td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="Students.html">
            <td>User1</td>
            <td>1st</td>
            <td>100%</td>
            <td>2.0</td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="Students.html">
            <td>User1</td>
            <td>1st</td>
            <td>100%</td>
            <td>2.0</td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="Students.html">
            <td>User1</td>
            <td>1st</td>
            <td>100%</td>
            <td>2.0</td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="Students.html">
            <td>User1</td>
            <td>1st</td>
            <td>100%</td>
            <td>2.0</td>
        </tr>
    </tbody>
</table></body>
<div id="myPlot" style="width:100%; border:none"></div>

<form action="/action_page.php">
    <select name="Sec">
        <option value="sec1">All Sections</option>
    </select>
    <br><br>
</form>
<div class="search">
    <input type="text" placeholder="Please enter name" required />
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const rows = document.querySelectorAll("tr[data-href]");

        rows.forEach(row => {
            row.addEventListener("click", () => {
                window.location.href = row.dataset.href;
            });
        });
    });
</script>

<script>
    const xArray = ["Section#1", "Section#2", "Section#3", "Section#4", "Section#5"];
    const yArray = [55, 49, 44, 24, 15];

    const data = [{
        x: xArray,
        y: yArray,
        type: "bar",
        orientation: "v",
        marker: { color: "rgba(0,0,255,0.6)" }
    }];

    const layout = { title: "Progress Check" };

    Plotly.newPlot("myPlot", data, layout);
</script>


</html>