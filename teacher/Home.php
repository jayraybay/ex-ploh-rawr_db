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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
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
        <li><a href="Content.php" class="nav-link">Content</a></li>
        <li><a href="student_acc.html" class="nav-link">Account</a></li>
        <li><a href="teacherProfile.html" class="nav-link">Settings</a></li>
    </ul>
</nav>
<main>
    <h2>Dashboard</h2>
    <div class="dashboard">
        <button onclick="DashboardPrev()"><span class="material-symbols-outlined">chevron_left</span></button>
        
        <!-- Average Mastery of each section -->
        <div class="content">
            <section id="section_mastery" class="section_mastery">
                <h2>Section Mastery</h2>
                <p>Average Mastery of each section</p>
                <br/>

                <?php
                    $get_sections = $conn->query("SELECT * FROM Section;");

                    while ($row = $get_sections->fetch_assoc()) {
                        $section = $row["Name"];
                        $average = ($conn->query("SELECT AVG(Mastery) AS Average_Mastery FROM Student WHERE Section='" . $row["Name"] . "';"))->fetch_assoc();

                        echo "<div class=\"ms_name\">" . $section . "</div>";
                        echo "<div class=\"ms_average\">" . number_format($average["Average_Mastery"], 2) . "</div>";
                        echo "<br/>";
                    }
                ?>
            </section>

            <section id="section_toppers" class="section_toppers">
                <h2>Leading Students</h2>
                <p>Top Three students based on mastery on each section</p>
                <br/>

                <?php
                    $get_sections = $conn->query("SELECT * FROM Section;");

                    while ($row = $get_sections->fetch_assoc()) {
                        $section = $row["Name"];
                        $topper = ($conn->query("SELECT `First_Name`, `Middle_Initials`, `Last_Name`, `PlayerName`, `Mastery` FROM Student WHERE Section='" . $row["Name"] . "' ORDER BY `Mastery` ASC LIMIT 3;"));

                        $top1 = $topper->fetch_assoc();
                        $top2 = $topper->fetch_assoc();
                        $top3 = $topper->fetch_assoc();
                        
                        echo "<div class=\"ms_name\">" . $section . "</div>";
                        echo "<div>" .
                             "<span class=\"ms_topper topper1\" title=\" ". htmlspecialchars($top1["First_Name"] . " " . $top1["Middle_Initials"] . " ". $top1["Last_Name"]) . "\" > <span class=\"ms_pos1\">1st</span> " . htmlspecialchars($top1["PlayerName"]) . " <span class=\"ms_mastery\">(" . htmlspecialchars($top1["Mastery"]) . ")</span></span>" .
                             "<span class=\"ms_topper topper2\" title=\" ". htmlspecialchars($top2["First_Name"] . " " . $top2["Middle_Initials"] . " ". $top2["Last_Name"]) . "\" > <span class=\"ms_pos2\">2nd</span> " . htmlspecialchars($top2["PlayerName"]) . " <span class=\"ms_mastery\">(" . htmlspecialchars($top2["Mastery"]) . ")</span></span>" .
                             "<span class=\"ms_topper topper3\" title=\" ". htmlspecialchars($top3["First_Name"] . " " . $top3["Middle_Initials"] . " ". $top3["Last_Name"]) . "\" > <span class=\"ms_pos3\">3rd</span> " . htmlspecialchars($top3["PlayerName"]) . " <span class=\"ms_mastery\">(" . htmlspecialchars($top3["Mastery"]) . ")</span></span>" .
                             "</div>";
                        echo "<br/>";
                    }
                ?>
            </section>
        </div>
        <button onclick="DashboardNext()"><span class="material-symbols-outlined">chevron_right</span></button>
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
                    echo "<td><a href=\"Students.php?id=" . htmlspecialchars($row["ID"]) . "\">View</a></td>";
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

<script>
    
    
// Top Three Students regardless of section
const DB_TOPPER = document.getElementById("section_toppers");
// Average Mastery of each section
const DB_SECTOR = document.getElementById("section_mastery");


var DASHBOARD_INDEX;

window.onload = function () {
    DASHBOARD_INDEX = 1;
    ShowDashboard(1);
}

function DashboardPrev() {
    DASHBOARD_INDEX--;
    if (DASHBOARD_INDEX < 1) { DASHBOARD_INDEX = 1; }
    ShowDashboard(DASHBOARD_INDEX);
}

function DashboardNext() {
    DASHBOARD_INDEX++;
    if (DASHBOARD_INDEX > 2) { DASHBOARD_INDEX = 1; }
    ShowDashboard(DASHBOARD_INDEX);
}

function ShowDashboard(page=0) {

    switch (page) {
        case 1:
            DB_TOPPER.style.display = "none";
            DB_SECTOR.style.display = "block";
            break;
        case 2:
            DB_TOPPER.style.display = "block";
            DB_SECTOR.style.display = "none";
            break;

    }

}

</script>
</body>


<!--  irrelevant below -->

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