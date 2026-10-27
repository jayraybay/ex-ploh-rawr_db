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

$retrieve_sections = $conn->query("SELECT * FROM Section;");
?>


<!DOCTYPE html>
<html>
<link rel="stylesheet" href="Screate_acc.css" />
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

    <form action="/action_page.php">
        <div class="container">
            <h1>Register Student</h1>
            <hr>

            <label for="email"><b>First Name</b></label>
            <input type="text" placeholder="First Name" name="email" id="email" required>

            <label for="email"><b>Middle Name</b></label>
            <input type="text" placeholder="Middle Initial" name="email" id="email" required>

            <label for="email"><b>Last Name</b></label>
            <input type="text" placeholder="Last Name" name="email" id="email" required>

            <label for="email"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="email" id="email" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
            <hr>

            <button type="submit" class="registerbtn">Register Student</button>
        </div>
    </form>

</body>
</html>
