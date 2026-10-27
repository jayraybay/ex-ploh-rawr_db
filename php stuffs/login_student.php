<?php
$servername = "explorer-server.mysql.database.azure.com";
$username = "xdifhddbhh";
$password = "w8J523yFSqAcI5X$";
$dbname = "divinedb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo "Connection Failed";
    die("Connection failed: " . $conn->connect_error);
}

$input_id = $_POST["id"] ?? "NONE";
$input_pwd = $_POST["pwd"] ?? "NONE";

$get_creds = "SELECT `ID`, `Password`, `FName`, `MName`, `LName`, `Section` FROM Student WHERE " .
             "ID='" . $input_id . "' AND " .
             "Password='" . $input_pwd . "'";

$res_creds = $conn->query($get_creds);
if ($res_creds->num_rows == 1) {
    //echo "SUCCESS"; // login
    $r = $res_creds->fetch_assoc();
    $p = $conn->query("SELECT `PlayerName`, `PlayerGender`, `Progress`, `Mastery` FROM Player WHERE ID='" . $r["ID"] . "'")->fetch_assoc();

    echo $r["ID"] . "|" . $r["Password"] . "|" . $r["FName"] . "|" . $r["MName"] . "|" . $r["LName"] . "|" . $r["Section"] . "|" . $p["PlayerName"] . "|" . $p["PlayerGender"];
} else {
    echo "FAIL"; // doesn't exists or wrong password
}
?>