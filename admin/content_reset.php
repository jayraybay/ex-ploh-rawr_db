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

<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../common.css"/>
    <link rel="stylesheet" href="Home.css" />
    <link rel="stylesheet" href="content_reset.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_back" />
</head>
    <body>
        <header>
            <a href="#default" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc"><span>Divine Mercy College Foundation Inc.</span></a>
        </header>

    <main>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST["id"];
            $question = $_POST["question"];
            $choice1 = $_POST["choice1"];
            $choice2 = $_POST["choice2"];
            $choice3 = $_POST["choice3"];
            $choice4 = $_POST["choice4"];
            $answer = $_POST["answer"];
            $option = $_POST["option"];
            
            if ($option == "default") {
                //"SELECT `Indicate`, `Exam`, `Choice1`, `Choice2`, `Choice3`, `Choice4`, `Answer` FROM Teacher_Content;";

                $conn->query("UPDATE Admin_Content SET Exam='".$question."', Choice1='".$choice1."', Choice2='".$choice2."', Choice3='".$choice3."', Choice4='".$choice4."' WHERE Indicate=".$id.";");
                $ans = "";
                
                     if ($answer == "1") { $ans = $choice1; }
                else if ($answer == "2") { $ans = $choice2; }
                else if ($answer == "3") { $ans = $choice3; }
                else if ($answer == "4") { $ans = $choice4; }

                $conn->query("UPDATE Admin_Content SET Answer='".$ans."' WHERE Indicate=".$id.";");

            }
            
            header("Location: content_reset.php");
            exit;
        }
        ?>

    <h2><a href="admin_home.php"><span class="material-symbols-outlined">arrow_back</span></a>Set Default Content</h2>
    <table id="primaryTable">
    <thead>
        <tr>
            <th class="indi" style="width: 10px;">Index</th>
            <th class="ques">Questions</th>
            <th>Choice 1</th>
            <th>Choice 2</th>
            <th>Choice 3</th>
            <th>Choice 4</th>
            <th>Answer</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="tBody">
        <?php
            $retrieve_questions = $conn->query("SELECT `Indicate`, `Exam`, `Choice1`, `Choice2`, `Choice3`, `Choice4`, `Answer` FROM Admin_Content;");
            while ($row = $retrieve_questions->fetch_assoc()) {
                $id = $row["Indicate"];
                $question = $row["Exam"];
                $choice1 = $row["Choice1"];
                $choice2 = $row["Choice2"];
                $choice3 = $row["Choice3"];
                $choice4 = $row["Choice4"];
                $answer = $row["Answer"];
                echo "<tr>".
                     "<td>". "<form method='POST' action='' id='form-".htmlspecialchars($id)."' style='visibility:hidden; position:absolute'></form>" . "<input type='text' name='id' value='". htmlspecialchars($id) ."' form='form-". htmlspecialchars($id) ."' readonly>" ."</td>" .
                     "<td>". "<input type='text' placeholder='Insert Question' name='question' required form='form-".htmlspecialchars($id)."' value='".$question."'></td>".
                     "<td>". "<input type='text' placeholder='Insert 1st Choice' name='choice1' required form='form-".htmlspecialchars($id)."' value='".$choice1 . "'>"."</td>".
                     "<td>". "<input type='text' placeholder='Insert 2nd Choice' name='choice2' required form='form-".htmlspecialchars($id)."' value='".$choice2 . "'>"."</td>".
                     "<td>". "<input type='text' placeholder='Insert 3rd Choice' name='choice3' required form='form-".htmlspecialchars($id)."' value='".$choice3 . "'>"."</td>".
                     "<td>". "<input type='text' placeholder='Insert 4th Choice' name='choice4' required form='form-".htmlspecialchars($id)."' value='".$choice4 . "'>"."</td>".
                     "<td><select name='answer' form='form-".htmlspecialchars($id)."'>".
                        ($choice1 == $answer ? "<option value='1' selected form='form-".htmlspecialchars($id)."'>Choice 1</option>" : "<option value='1' form='form-".htmlspecialchars($id)."'>Choice 1</option>") . 
                        ($choice2 == $answer ? "<option value='2' selected form='form-".htmlspecialchars($id)."'>Choice 2</option>" : "<option value='2' form='form-".htmlspecialchars($id)."'>Choice 2</option>") . 
                        ($choice3 == $answer ? "<option value='3' selected form='form-".htmlspecialchars($id)."'>Choice 3</option>" : "<option value='3' form='form-".htmlspecialchars($id)."'>Choice 3</option>") . 
                        ($choice4 == $answer ? "<option value='4' selected form='form-".htmlspecialchars($id)."'>Choice 4</option>" : "<option value='4' form='form-".htmlspecialchars($id)."'>Choice 4</option>") . 
                        "</select></td>" .
                     "<td>" ."<button type='submit' value='default' name='option' form='form-". htmlspecialchars($id) ."'>Save As Default</button>".
                     "</tr>";
            }
        ?>
               
        <!--
        <tr>
            <td>
                <form method="POST" id="form-1" action=""></form>
                <input type="text" name="id">
            </td>
            <td><input type="text" placeholder="Insert question" name="question"  required form="form-1"></td>
            <td><input type="text" placeholder="Insert 1st choice" name="choice1" required form="form-1"></td>
            <td><input type="text" placeholder="Insert 2nd choice" name="choice2" required form="form-1"></td>
            <td><input type="text" placeholder="Insert 3rd choice" name="choice3" required form="form-1"></td>
            <td><input type="text" placeholder="Insert 4th choice" name="choice4" required form="form-1"></td>
            <td><input type="text" placeholder="Insert answer" name="answer"></td>
            <td><button type="button">save</button>
            
        </tr>-->
        
    </tbody>
</table>
<button type="button" onclick="addNewQuestion()">Add new question</button>
</main>

<script>
    var mainTable = document.getElementById("primaryTable");
    function addNewQuestion1() {    
    document.getElementById("primaryTable").insertRow(-1).innerHTML = '<tr><td><textarea name="Question" placeholder="Question" th:field="${questionAnswerSet.question}" id="question" style = "resize: none; width:100%;"></textarea></td><td><textarea name="Answer" placeholder ="Answer" th: field="${questionAnswerSet.answer}" id="answer" style="resize:none;width: 100%;"></textarea></td ></tr>';
    }

    function addNewQuestion() {
        var num = mainTable.rows.length;
        var formId = "form-"+num;
        document.getElementById("primaryTable").insertRow().innerHTML = '<tr><td><form id="'+formId+'" method="POST" action="/submit/'+formId+'"></form><input type="text" placeholder="Index here" name="index" form="'+formId+'" style="text-align: center;" readonly value="'+num+'"></td><td><input type="text" placeholder="Insert question" name="question" form='+formId+'></td><td><input type="text" placeholder="Insert 1st choice" name="choice1" form="'+formId+'"></td><td><input type="text" placeholder="Insert 2nd choice" name="choice2" form="'+formId+'"></td><td><input type="text" placeholder="Insert 3rd choice" name="choice3" form="'+formId+'"></td><td><input type="text" placeholder="Insert 4th choice" name="choice4" form="'+formId+'"></td><td><input type="text" placeholder="Insert answer" name="answer" form="'+formId+'"></td><td><button type="button" form="'+formId+'">Set default</button></tr>';
    }
</script>
</body>
</html>