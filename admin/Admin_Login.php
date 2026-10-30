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
<head>
    <link rel="stylesheet" href="Admin_Login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_back" />
</head>
<div class="header">
    <a href="../index.html" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc">Divine Mercy College Foundation Inc.</a>
</div>

<body>
    <div class="wrapper">
        <h3><a href="../index.html"><span class="material-symbols-outlined">arrow_back</span></a> Admin Login</h3>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="input_box">
                <input id="admin_user" type="text" placeholder="Admin" required name="a_user" onchange="RemoveWrong()" />
                <i class='bx bxs-user'></i>
            </div>
            <div class="input_box">
                <input id="admin_pwd" type="password" placeholder="Password" required name="a_pwd" />
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>

        <?php
        $a_user = $a_pwd = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $a_user = $_POST["a_user"];
            $a_pwd = $_POST["a_pwd"];

            $login_admin = $conn->query("SELECT * FROM Admin WHERE " .
                                        "Name='" . $a_user . "' AND " .
                                        "Password='" . $a_pwd . "'"      );

            if ($login_admin->num_rows > 0) {
                $_SESSION['admin_user'] = $a_user;
                $_SESSION['admin_pwd'] = $a_pwd;
                header("Location: admin_home.php");

                exit;
            } else {
                echo "<div id=\"wrong_login\">Wrong User or Password</div>";
            }
        }

        ?>
    </div>

    <img src="tANA0h-1717114438.png" />
    <script src="admin_login.js"></script>
</body>


</html>