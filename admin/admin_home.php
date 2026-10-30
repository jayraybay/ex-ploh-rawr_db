<?php
session_start();
$host = "localhost"; 
$username = "root";
$password = "";
$dbname = "divinedb";
$port = 3306;

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("". $conn->connect_error);
}


$a_user = "";
$a_pwd = "";
if (isset($_SESSION['admin_user'])) { $a_user = $_SESSION['admin_user']; }
if (isset($_SESSION['admin_pwd'])) { $a_pwd = $_SESSION['admin_pwd']; }

$retrieve_students = $conn->query("SELECT * FROM Student;");
$retrieve_teachers = $conn->query("SELECT * FROM Teacher;");
$retrieve_questions = $conn->query("SELECT * FROM Teacher_Content;");
?>
<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="admin_home.css"/>
    <link rel="stylesheet" type="text/css" href="../common.css"/>
</head>
<body>

<header>
    <a href="#default" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc"><span>Divine Mercy College Foundation Inc.</span></a>
</header>

<div class="thirty-sixty">
<nav>
    <ul>
        <li><a href="admin_home.php" class="nav-link">Home</a></li>
        <li><a href="#manage_students" class="nav-link">Manage Students</a></li>
        <li><a href="#manage_teachers" class="nav-link">Manage Teachers</a></li>
        <li><a href="content_reset.php" class="nav-link">Manage Content</a></li>
        <li><a href="admin_profile.php" class="nav-link">Account</a></li>
    </ul>
</nav>
<main>
    <h2 style="margin-top: 5%">Dashboard</h2>
    <div class="dashboard">
        <section class="students">
            <h2>Students</h2>
            <?php echo "<b>" . $retrieve_students->num_rows . "</b>"; ?>
        </section>

        <section class="teachers">
            <h2>Teachers</h2>
            <?php echo "<b>" . $retrieve_teachers->num_rows . "</b>"; ?>
        </section>

        <section class="questions">
            <h2>Questions</h2>
            <?php echo "<b>" . $retrieve_questions->num_rows . "</b>"; ?>
        </section>
    </div>

    <h2 id="manage_students">Manage Students</h2>
    <form><!--
        <input type="text" placeholder="Please enter name" required /> -->
        <a class="btn_create" href="Screate_acc.php" >Create Student Account</a>
    </form>
    
    <table>
        <thead>
            <tr>
                <th class="name">ID</th>
                <th class="Sname">Name</th>
                <th class="pass">Section</th>
                <th class="sel">Option</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($retrieve_students->num_rows > 0) {
                    while ($row = $retrieve_students->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["ID"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["PlayerName"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Section"]) . "</td>";
                        echo "<td><a href=\"student_acc.php?id=". htmlspecialchars($row["ID"]) ."\">Edit</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }            
            ?>
        </tbody>
    </table>
    
    <h2 id="manage_teachers">Manage Teachers</h2>
    <form>
    <!--
    <input type="text" placeholder="Please enter name" required /> -->
    <a href="Tcreate_acc.php">Create Teacher Account</a></form>
    <table>
        <thead>
            <tr>
                <th class="name">ID</th>
                <th class="Sname">Name</th>
                <th class="sel">Option</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($retrieve_teachers->num_rows > 0) {
                    while ($row = $retrieve_teachers->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["ID"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["First_Name"]) . " " . htmlspecialchars($row["Middle_Initials"]) . " " . htmlspecialchars($row["Last_Name"]) . "</td>";
                        echo "<td><a href=\"teacher_acc.php?id=\"". htmlspecialchars($row["ID"]) ."\">Edit</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }
                $conn->close();
        ?>
        </tbody>
    </table>
</main>
</body>
</html>