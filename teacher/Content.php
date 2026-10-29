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

        <link rel="stylesheet" type="text/css" href="../common.css"/>
        <link rel="stylesheet" href="Home.css" />
        <link rel="stylesheet" href="Content.css" />

    <body>
        <header>
            <a href="#default" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc"><span>Divine Mercy College Foundation Inc.</span></a>
        </header>

    <main>
<table>
    <thead>
        <tr>
            <th class="indi" style="width: 10px;">Index</th>
            <th class="ques" style="width: ;">Questions</th>
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
            $retrieve_questions = $conn->query("SELECT `Indicate`, `Exam`, `Choice1`, `Choice2`, `Choice3`, `Choice4`, `Answer` FROM Teacher_Content;");
            while ($row = $retrieve_questions->fetch_assoc()) {
                $id = $row["Indicate"];
                $question = $row["Exam"];
                $choice1 = $row["Choice1"];
                $choice2 = $row["Choice2"];
                $choice3 = $row["Choice3"];
                $choice4 = $row["Choice4"];
                $answer = $row["Answer"];
                echo "<tr>".
                     "<td>". "<form method='POST' action='' id='form-".htmlspecialchars($id)."' style='visibility:hidden; position:absolute'></form>" . "<input type='text' name='id' value='". htmlspecialchars($id) ."' readonly>" ."</td>" .
                     "<td>". "<input type='text' placeholder='Insert Question' name='question' required form='form-".htmlspecialchars($id)."' value='". $question ."'></td>".
                     "<td>". "<input type='text' placeholder='Insert 1st Choice' name='choice1' required form='form-".htmlspecialchars($id)."' value='".$choice1 . "'>"."</td>".
                     "<td>". "<input type='text' placeholder='Insert 2nd Choice' name='choice2' required form='form-".htmlspecialchars($id)."' value='".$choice2 . "'>"."</td>".
                     "<td>". "<input type='text' placeholder='Insert 3rd Choice' name='choice3' required form='form-".htmlspecialchars($id)."' value='".$choice3 . "'>"."</td>".
                     "<td>". "<input type='text' placeholder='Insert 4th Choice' name='choice4' required form='form-".htmlspecialchars($id)."' value='".$choice4 . "'>"."</td>".
                     "<td><select name='answer'>".
                        "<option value='1'>Choice 1</option>" . 
                        "<option value='2'>Choice 2</option>" . 
                        "<option value='3'>Choice 3</option>" . 
                        "<option value='4'>Choice 4</option>" . 
                        "</select></td>" .
                     "<td>" . "<button type='submit' value='reset'>reset</button>" . "<button type='submit' value='save'>Save</button></td>" .
                     "</tr>";
            }
        ?>
        

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
            
        </tr>
            <!--
            <form>
                <td>1</td>
                <td><input type="text" placeholder="Insert question" name="question" required></td>
                <td><input type="text" placeholder="Insert 1st choice" name="choice1" required></td>
                <td><input type="text" placeholder="Insert 2nd choice" name="choice2" required></td>
                <td><input type="text" placeholder="Insert 3rd choice" name="choice3" required></td>
                <td><input type="text" placeholder="Insert 4th choice" name="choice4" required></td>
                <td><input type="text" placeholder="Insert answer" name="answer"></td>
                <td><button type="button">save</button>
                <button type="button">reset</button></td>
            </form>-->
        
    </tbody>
</table>
</main>
</body>
</html>