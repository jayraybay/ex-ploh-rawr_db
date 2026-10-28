<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="nav_admin_files\nav_admin_Q1GJ.css">
<link href="nav_admin_files\boxicons.min_Q1GJ.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="default_content.css"/>

</head><body style="height: 491.8px;"><div class="header">
    <a href="#default" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc">Divine Mercy College Foundation Inc.</a>
</div>
<div class="thirty-sixty">
    <nav>
    <ul class="nav-link">
        <li><a href="admin_home.php" class="nav-link" target="_Home">Home</a></li>
        <li><a href="default_content.php" target="_Home">Content</a></li>
        <li><a href="teacher_acc.php" class="nav-link" target="_Home">Manage Teacher</a></li>
        <li><a href="student_acc.php" class="nav-link" target="_Home">Manage Student</a></li>
        <li><a href="admin_profile.php" class="nav-link" target="_Home">Profile</a></li>
    </ul">
    </nav>
<main>
    <table>
    <thead>
        <tr>
            <th class="sel"></th>
            <th class="ques">Questions</th>
            <th class="Tags">Tags</th>
            <th class="ans">Answers</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
</table>
<form action="/action_page.php">
    <select name="Sec">
        <option value="sec1">Activity</option>
        <option value="sec2">Quiz</option>
        <option value="sec3">Exam</option>
        <option value="sec4">Puzzle</option>
    </select>
    <br><br>
</form>
<div class="search">
    <input type="text" placeholder="Please enter name" required />
</div>

<div class="edit">
    <button id="openPromptBtn">Edit Content</button>
</div>

<dialog id="multiPrompt">
    <form method="dialog" id="promptForm" name="edtbtn">
        <h3>Enter Details</h3>

        <label for="ques">Question:</label>
        <input type="text" id="question" required><br><br>

        <label for="choose">Choice:</label>
        <input type="text" id="choice" required><br><br>

        <label for="ans">Answer:</label>
        <input type="text" id="answer" required><br><br>

        <button type="button" id="cancelBtn">Cancel</button>
        <button type="submit" id="submitBtn">Submit</button>
    </form>
</dialog>
</main>

<script>
                const dialog = document.getElementById('multiPrompt');
const openBtn = document.getElementById('openPromptBtn');
const cancelBtn = document.getElementById('cancelBtn');
const form = document.getElementById('promptForm');

// Show the custom prompt
openBtn.addEventListener('click', () => {
      form.reset(); // Clear old values
      dialog.showModal();
});

// Close prompt if cancelled
cancelBtn.addEventListener('click', () => {
      dialog.close();
});

// Handle data submission
form.addEventListener('submit', (e) => {
      e.preventDefault(); // Prevent page reload

      const firstName = document.getElementById('firstName').value;
      const lastName = document.getElementById('lastName').value;

      console.log("First Name:", firstName);
      console.log("Last Name:", lastName);

      dialog.close(); // Close the modal
});
</script>



</html>