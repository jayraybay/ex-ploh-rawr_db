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

$data = "";

$t_ID = $_SESSION['teacher_ID'];
$t_pwd = $_SESSION['teacher_pwd'];
$data = $conn->query("SELECT `ID`, `Password`, `First_Name`, `Middle_Initials`, `Last_Name`, `Date_Joined` FROM Teacher WHERE ID='".$t_ID."';")->fetch_assoc();


?>

<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../common.css"/>
        <link rel="stylesheet" href="Home.css" />
        <link rel="stylesheet" href="teacherProfile.css" />
    </head>

<body>
    <header>
        <a href="#default" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc"><span>Divine Mercy College Foundation Inc.</span></a>
    </header>
    <div class="thirty-sixty">
<nav>
    <ul class="nav-link">
        <li><a href="Home.php" class="nav-link">Home</a></li>
        <li><a href="Content.php" class="nav-link">Content</a></li>
        <li><a href="teacherProfile.php" class="nav-link">Account</a></li>
    </ul>
</nav>
<main>
    <div class="name">
        <?php echo  "<p>" . $data["First_Name"] . " " . $data["Middle_Initials"] . " " . $data["Last_Name"] . "</p>"; ?>
    </div>
    <div class="entry" id="entry">
        <p><strong>Credentials</strong></p> 
        <p>Teacher ID: </p>
        <div class="entryLineToReplace">
            <?php echo "<p>" . $data["ID"] . "</p>"; ?></div>
        <p>Date joined: </p>
        <div class="entryLineToReplace">
            <?php echo "<p>" . $data["Date_Joined"] . "</p>"; ?>

            <form action="" method="POST">
                <button type="submit" name="logout" value="logout">Log out</button>
            </form>
        </div>
            <form action="" method="POST">
                <button value="change" type="button" name="enableChangePass" onclick="toggleChangePass()" id="togglePass">Change Password</button>
            </form>

            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
                    if (isset($_POST["logout"])) {
                        $_SESSION = array();
                        session_destroy();
                        header("Location:../index.html");
                        exit;
                    }
                }
            ?>
        </div>
</main>
</div>
<script>
var showingFields = false;
var br = document.createElement("br"); 

function toggleChangePass(){
        if (showingFields){
        removeForm();
    }else{

        addNewForms();
    }
}

function removeForm(){
    document.getElementById("togglePass").innerHTML = "Change Password";
    document.getElementById("changePassDiv").remove();
    showingFields = false;
}

function addNewForms(){
    showingFields = true;
    var newDiv = document.createElement("div")
    newDiv.setAttribute("class", "entry")
    newDiv.setAttribute("id", "changePassDiv");

    var newForm = document.createElement("form");
    var oldPass = document.createElement("input");
    oldPass.setAttribute("type", "password");
    oldPass.setAttribute("placeholder", "Enter old password");
    oldPass.setAttribute("name", "oldPass");

    var newPass = document.createElement("input");
    newPass.setAttribute("type", "password");
    newPass.setAttribute("placeholder", "Enter new password");
    newPass.setAttribute("name", "newPass");

    var confPass = document.createElement("input");
    confPass.setAttribute("type", "password");
    confPass.setAttribute("placeholder", "Re-enter new password");
    confPass.setAttribute("name", "confPass");



    var resetPass = document.createElement("button");
    resetPass.setAttribute("type", "button");
    resetPass.setAttribute("name", "resetPass");
    resetPass.setAttribute("name", "resetPass");
    
    var resetPass = document.createElement("button");
    resetPass.setAttribute("type", "password");
    resetPass.setAttribute("placeholder", "Re-enter new password");
    resetPass.setAttribute("name", "confPass");
    
    newForm.appendChild(oldPass); 
    newForm.appendChild(newPass); 
    newForm.appendChild(confPass); 
    newForm.appendChild(br.cloneNode());
    newForm.appendChild(br.cloneNode());
    newForm.appendChild(resetPass);  
    document.getElementsByTagName("main")[0].appendChild(newDiv);
    newDiv.appendChild(newForm);
    resetPass.innerHTML = "Change password";
    document.getElementById("togglePass").innerHTML = "Cancel";
    }
</script>
</body>
</html>