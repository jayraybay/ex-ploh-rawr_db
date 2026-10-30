<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "divinedb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("". $conn->connect_error);
}


$ID = $_GET["id"];
$retrieve_student = $conn->query("SELECT * FROM Student WHERE ID='" . $ID . "';");
$data = $retrieve_student->fetch_assoc();
?>

<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../common.css"/>
        <link rel="stylesheet" href="Home.css" />
        <link rel="stylesheet" href="Students.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_back" />
    </head>

    <body>
        <header>
            <a href="#default" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc"><span>Divine Mercy College Foundation Inc.</span></a>
        </header>
        <div class="thirty-sixty">
            <nav>
                <ul class="nav-link">
                    <li><a href="Home.php" class="nav-link">Home</a></li>
                    <li><a href="Home.php" class="nav-link">Dashboard</a></li>
                    <li><a href="teacher_acc.html" class="nav-link">Content</a></li>
                    <li><a href="student_acc.html" class="nav-link">Account</a></li>
                </ul>
            </nav>
    <main>
    <h1><a href="Home.php"><span class="material-symbols-outlined">arrow_back</span></a> View Student</h1>
    <div class="name">
        <?php echo "<p>" . htmlspecialchars($data["PlayerName"]) . "</p>"; ?>
    </div>
    <div class="entry">
        <p>Section: </p>
        <div class="entryLineToReplace">
            <?php echo "<p>" . htmlspecialchars($data["Section"]) . "</p>"; ?>
            </div><br>
        <p><strong>Credentials</strong></p> 
                <div class="mastery">
            <p>Mastery: </p>
            <?php echo "<p>" .  ($data["Mastery"]==null?"-":number_format(htmlspecialchars($data["Mastery"]), 2)) . "</p>"; ?>
        </div>
        <p>Full name: </p>
        <div class="entryLineToReplace">
            <?php echo "<p>" . htmlspecialchars($data["First_Name"]) . " " . htmlspecialchars($data["Middle_Initials"]) . " " . htmlspecialchars($data["Last_Name"]) . "</p>"; ?>
            </div><br>
        <p>Student ID: </p>
        <div class="entryLineToReplace">
            <?php echo "<p>" . htmlspecialchars($data["ID"]) . "</p>"; ?>
            </div><br>
        <p>Date joined: </p>
        <div class="entryLineToReplace">
            <?php echo "<p>" . htmlspecialchars($data["Date_Joined"]) . "</p>"; ?>
            </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 60%;">Chapter</th>
                <th>Pre-Test Score</th>
                <th>Post-Test Score</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Chapter 1</td>
                <td>15/15</td>
                <td>15/15</td>
            </tr>
            <tr>
                <td>Chapter 2</td>
                <td>20/20</td>
                <td>20/20</td>
            </tr>
        </tbody>
    </table>
</main>
</div>
</body>
</html>