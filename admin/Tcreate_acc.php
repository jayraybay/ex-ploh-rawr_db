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
<link rel="stylesheet" href="Tcreate_acc.css" />
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../common.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_back" />
</head>
<body>
    <header>
        <a href="#default" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc"><span>Divine Mercy College Foundation Inc.</span></a>
    </header>

    <form action="" method="POST">
        <div class="container">
            <h1><a href="admin_home.php"><span class="material-symbols-outlined">arrow_back</span></a>Register Teacher</h1>
            <hr>

            <label for="id"><b>Teacher ID</b></label>
            <input type="text" placeholder="ID" name="id" id="id" required>

            <label for="fname"><b>First Name</b></label>
            <input type="text" placeholder="First Name" name="fname" id="fname" required>

            <label for="mname"><b>Middle Name</b></label>
            <input type="text" placeholder="Middle Initial" name="mname" id="mname" required>

            <label for="lname"><b>Last Name</b></label>
            <input type="text" placeholder="Last Name" name="lname" id="lname" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

            <label for="psw-repeat"><b>Confirm Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
            <hr>
            <?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $id = $_POST["id"];
                    $fname = $_POST["lname"];
                    $mname = $_POST["mname"];
                    $lname = $_POST["lname"];
                    $pwd = $_POST["psw"];
                    $cpwd = $_POST["psw-repeat"];
        
                    if ($pwd != $cpwd) { // not matching password
                        echo "<div id=\"err_msg\">Both passwords doesn't match</div>";
                        exit;
                    } else {
                        $does_id_exists = $conn->query("SELECT * FROM Teacher WHERE id='" . $id . "';");
                        if ($does_id_exists->num_rows > 0) { // exists id!
                            echo "<div id=\"exists_id\">ID already taken</div>";
                            exit;
                        } else {             
                            // Data Joined Format: YYYY-MM-DD
                            $register = $conn->query("INSERT INTO Teacher VALUES (" .
                                                                                "'" . $id . "'," . 
                                                                                "'" . $pwd . "'," . 
                                                                                "'" . $fname . "'," . 
                                                                                "'" . $mname . "'," . 
                                                                                "'" . $lname . "'," .
                                                                                "'" . date('Y-m-d') . "'" .
                                                                                ");");
                            echo "<div id=\"err_msg\">Teacher " . htmlspecialchars($id) . " registered</div>";
                        }
                    }
                }
            ?>
            <button type="submit" class="registerbtn">Register Teacher</button>
           
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
