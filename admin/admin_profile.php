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
$a_name = $_SESSION['admin_user'];
$a_pwd = $_SESSION['admin_pwd'];
$data = $conn->query("SELECT `Name`, `Password`, `Date_Joined` FROM `Admin` WHERE `Name`='".$a_name."';")->fetch_assoc();

?>

<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="nav_admin_files\nav_admin_Q1GJ.css">
<link rel="stylesheet" href="nav_admin_files\boxicons.min_Q1GJ.css">
<!-- <link rel="stylesheet" href="admin_profile.css"/> -->
<link rel="stylesheet" href="../teacher/teacherProfile.css"/> <!-- Some code bullshit wont let the text align on the left when using admin_profile.css; using the same css on used on the teacher self profile -->

    </head><body style="height: 491.8px;"><div class="header">
        <a href="#default" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc">Divine Mercy College Foundation Inc.</a>
    </div>
    <div class="thirty-sixty">
<nav>
    <ul class="nav-link">
        <li><a href="admin_home.php" class="nav-link">Home</a></li>
        <li><a href="student_acc.php" class="nav-link">Manage Students</a></li>
        <li><a href="teacher_acc.php" class="nav-link">Manage Teachers</a></li>
        <li><a href="content_reset.php" class="nav-link">Manage Content</a></li>
        <li><a href="admin_profile.php" class="nav-link">Account</a></li>
    </ul>
</nav>
    <main>
    <div class="name">
        <p>Admin</p>
    </div>
    <div class="entry" id="entry">
        <p><strong>Credentials</strong></p> 
        
        <p>Date joined: </p>
        <div class="entryLineToReplace">
            <?php echo $data["Date_Joined"]; ?>
        </div>

        <form action="" method="POST">
             <button type="submit" name="logout" value="logout">Log out</button>
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

        <form>
               
                <button type="button" name="enableChangePass" onclick="toggleChangePass()" id="togglePass">Change Password</button>
        </form>  
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
        newForm.appendChild(br.cloneNode());
    newForm.appendChild(newPass); 
        newForm.appendChild(br.cloneNode());
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