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

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Screate_acc.css" />
    <link rel="stylesheet" href="../common.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_back" />
</head>
<body>
<header>
    <a href="#default" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc"><span>Divine Mercy College Foundation Inc.</span></a>
</header>
    <form action="" method="POST">
        <div class="container">
            <h1><a href="admin_home.php"><span class="material-symbols-outlined">arrow_back</span></a>Register Student</h1>
            <hr>

            <label for="id"><b>Student ID</b></label>
            <input type="text" placeholder="ID" name="id" id="id" required>

            <label for="fname"><b>First Name</b></label>
            <input type="text" placeholder="First Name" name="fname" id="fname" required>

            <label for="mname"><b>Middle Name</b></label>
            <input type="text" placeholder="Middle Initial" name="mname" id="mname" required>

            <label for="lname"><b>Last Name</b></label>
            <input type="text" placeholder="Last Name" name="lname" id="lname" required>

            <label for="section"><b>Section</b></label>
            <select id="section" name="sec" class="section" style="display: block; width: 100%; padding: 15px; margin: 5px 0 22px 0; border: none; background: #f1f1f1;">
                <?php
                    echo "<option>-- No Selected --</option>";
                    $retrieve_sections = $conn->query("SELECT * FROM Section;");
                    while ($row = $retrieve_sections->fetch_assoc()) { // get all section names
                        echo "<option>" . htmlspecialchars($row["Name"]); "</option>";
                    }
                ?>
            </select>

            <label for="player"><b>Username</b></label>
            <input type="text" placeholder="Enter Player Name" name="player" id="player" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
            <hr>

            <button type="submit" class="registerbtn">Register Student</button>
            <?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $id = $_POST["id"];
                    $fname = $_POST["fname"];
                    $mname = $_POST["mname"];
                    $lname = $_POST["lname"];
                    $sec = $_POST["sec"];
                    $user = $_POST["player"];
                    $pwd = $_POST["psw"];
                    $cpwd = $_POST["psw-repeat"];
        
                    if ($pwd != $cpwd) { // not matching password
                        echo "<div id=\"err_msg\">Both passwords doesn't match</div>";
                        exit;
                    } else if ($sec == "-- No Selected --") {
                        echo "<div id=\"err_msg\">No section selected</div>";
                        exit;
                    } else {
                        $does_id_exists = $conn->query("SELECT * FROM Student WHERE id='" . $id . "';");
                        if ($does_id_exists->num_rows > 0) { // exists id!
                            echo "<div id=\"exists_id\">ID already taken</div>";
                            exit;
                        } else {             
                            // Data Joined Format: YYYY-MM-DD
                            $register = $conn->query("INSERT INTO Student VALUES (" .
                                                                                "'" . $id . "'," . 
                                                                                "'" . $pwd . "'," . 
                                                                                "'" . $fname . "'," . 
                                                                                "'" . $mname . "'," . 
                                                                                "'" . $lname . "'," . 
                                                                                "'" . $sec . "'," .
                                                                                "'" . $user . "'," .
                                                                                "'N'," .
                                                                                "0," .
                                                                                "0," .
                                                                                "'" . date('Y-m-d') . "'" .
                                                                                ");");
                            echo "<div id=\"err_msg\">Student " . htmlspecialchars($id) . " registered</div>";
                        }
                    }
                }
            ?>
            
        </div>
    </form>

    <script>
        var TOASTER;

        function OnChangeInput() {
            TOASTER.document.getElementById("err_msg"); // not really err, just a toaster
            TOASTER.remove();
        }
    </script>
</body>
</html>
