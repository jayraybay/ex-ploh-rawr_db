<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "divinedb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("". $conn->connect_error);
}

?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="Login_teacher.css"> 
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<div class="header">
    <a href="../index.html" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc">Divine Mercy College Foundation Inc.</a>
</div>
<body>

    <div class="wrapper">
        <h3>Teacher Login</h3>
        <form action="" method="post">
            <div class="input_box">
                <input type="text" placeholder="Teacher ID" required name="t_id"/>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input_box">
                <input type="password" placeholder="Password" required name="t_pwd"/>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <?php
        $t_id = $t_pwd = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $t_id = $_POST["t_id"];
            $t_pwd = $_POST["t_pwd"];

            $login_teacher = $conn->query("SELECT * FROM Teacher WHERE " .
                                        "ID='" . $t_id . "' AND " .
                                        "Password='" . $t_pwd . "'"      );

            if ($login_teacher->num_rows > 0) {
                $_SESSION['teacher_ID'] = $t_id;
                $_SESSION['teacher_pwd'] = $t_pwd;
                
                header("Location: Home.php");
                exit;
            } else {
                echo "<div id=\"wrong_login\">Wrong ID or Password</div>";
            }
        }
        ?>
    </div>
    <img src="tANA0h-1717114438.png" />
    <script src="teacher_login.js"></script>
</body>
</html>