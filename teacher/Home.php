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

$t_ID = "";
$t_pwd = "";
if (isset($_SESSION['teacher_ID'])) { $t_ID = $_SESSION['teacher_ID']; }
if (isset($_SESSION['teacher_pwd'])) { $t_ID = $_SESSION['teacher_pwd']; }

$retrieve_students = $conn->query("SELECT ROW_NUMBER() OVER (ORDER BY Mastery ASC) AS Rank, ID, PlayerName, Progress, Mastery FROM Student; ");
?>

<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="Home.css" />
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>

<header>
    <a href="#default" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc"><span>Divine Mercy College Foundation Inc.</span></a>
</header>

<div class="thirty-sixty">
<nav>
    <ul class="nav-link">
        <li><a href="admin_home.html" class="nav-link">Home</a></li>
        <li><a href="default_content.html" class="nav-link">Dashboard</a></li>
        <li><a href="teacher_acc.html" class="nav-link">Content</a></li>
        <li><a href="student_acc.html" class="nav-link">Account</a></li>
        <li><a href="teacherProfile.html" class="nav-link">Settings</a></li>
    </ul>
</nav>
<main>
    <h2>Dashboard</h2>
    <div class="dashboard">
        <button onclick="DashboardPrev()"></button>

        <div class="content">

        <section class="top">
            <h3>Top Three (3) Progress</h3>
            
            <?php
                $get_top_progress = $conn->query("SELECT * FROM Student ORDER BY Progress ASC LIMIT 3;");
                if ($get_top_progress->num_rows >= 3) {
                    $row1 = $get_top_progress->fetch_assoc();
                    echo "<div>1st " . htmlspecialchars($row1["PlayerName"]) . " (" . htmlspecialchars($row1["Progress"]) . ")</div>";

                    $row2 = $get_top_progress->fetch_assoc();
                    echo "<div>2nd " . htmlspecialchars($row2["PlayerName"]) . " (" . htmlspecialchars($row2["Progress"]) . ")</div>";

                    $row3 = $get_top_progress->fetch_assoc();
                    echo "<div>3rd " . htmlspecialchars($row3["PlayerName"]) . " (" . htmlspecialchars($row3["Progress"]) . ")</div>";
                } else {
                    echo "<div>No records found.";
                }
            ?>
        </section>

        <section class="top">
            <h3>Top Three (3) Mastery</h3>
            <?php
                $get_top_mastery = $conn->query("SELECT * FROM Student ORDER BY Mastery ASC LIMIT 3;");
                if ($get_top_mastery->num_rows >= 3) {
                    $row1 = $get_top_mastery->fetch_assoc();
                    echo "<div>1st " . htmlspecialchars($row1["PlayerName"]) . " (" . htmlspecialchars($row1["Mastery"]) . ")</div>";

                    $row2 = $get_top_mastery->fetch_assoc();
                    echo "<div>2nd " . htmlspecialchars($row2["PlayerName"]) . " (" . htmlspecialchars($row2["Mastery"]) . ")</div>";

                    $row3 = $get_top_mastery->fetch_assoc();
                    echo "<div>3rd " . htmlspecialchars($row3["PlayerName"]) . " (" . htmlspecialchars($row3["Mastery"]) . ")</div>";
                } else {
                    echo "<div>No records found.";
                }
            ?>
        </section>
        </div>
        <button onclick="DashboardNext()"></button>
    </div>
    
    <br/>

    <h2>Leaderboards</h2>
    <form action="/action_page.php">
        <select name="Sec">
            <option value="sec1">All Sections</option>
            <option value="sec1">Grade 12 - Trustworthy (ICT)</option>
        </select>
        <input type="text" placeholder="Please enter name" required name="searchStudent" />
    </form> 
    
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Progress</th>
                <th>Mastery</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($retrieve_students->num_rows > 0) {
                    while ($row = $retrieve_students->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["Rank"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["PlayerName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Progress"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Mastery"]) . "</td>";
                    echo "<td><a href=\"student_acc.php?id=\"". htmlspecialchars($row["ID"]) . "\">View</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</main>
</div>

<script src="teacher_home.js"></script>
</body>
<!--this part is for selecting a single student and 
the data for the chart-->
<!--
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
</script> -->
</html>