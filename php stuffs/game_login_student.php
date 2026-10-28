<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "divinedb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo "Connection Failed";
    die("Connection failed: " . $conn->connect_error);
}

$input_id = $_POST["id"] ?? "NONE";
$input_pwd = $_POST["pwd"] ?? "NONE";

$get_creds = "SELECT `ID`, `Password`, `First_Name`, `Middle_Initials`, `Last_Name`, `Section`, `PlayerName`, `PlayerGender`, `Progress`, `Mastery` FROM Student WHERE " .
             "ID='" . $input_id . "' AND " .
             "Password='" . $input_pwd . "'";

$res_creds = $conn->query($get_creds);
if ($res_creds->num_rows == 1) {
    //echo "SUCCESS"; // login
    $r = $res_creds->fetch_assoc();

    echo $r["ID"] . "|" . $r["Password"] . "|" . $r["First_Name"] . "|" . $r["Middle_Initials"] . "|" . $r["Last_Name"] . "|" . $r["Section"] . "|" . $p["PlayerName"] . "|" . $p["PlayerGender"];
} else {
    echo "FAIL"; // doesn't exists or wrong password
}

// REVAMP select because a lot has changed. Student and Player merged into one for instance.

?>