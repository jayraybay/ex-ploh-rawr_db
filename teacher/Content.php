<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="nav_files/nav_ZZMT.css">
<link href="nav_files/boxicons.min_ZZMT.css" rel="stylesheet">
<link rel="stylesheet" href="Content.css"/>

</head><body style="height: 491.8px;"><div class="header">
    <a href="#default" class="logo"><img src="tANA0h-1717114438.png" alt="dmfc">Divine Mercy College Foundation Inc.</a>
</div>


     <div class="thirty-sixty">
        <nav>
        <ul class="nav-link">
            <li><a href="home.php" class="nav-link" target="_Home">Home</a></li>
            <li><a href="Content.php" target="_Home">Content</a></li>
            <li><a href="teacherProfile.php" class="nav-link" target="_Home">Profile</a></li>
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
    <tbody id="tBody">
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody id="tBody">
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody id="tBody">
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody id="tBody">
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody id="tBody">
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody id="tBody">
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody id="tBody">
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
    <tbody id="tBody">
        <tr>
            <td><input type="checkbox" /></td>
            <td>Question#1</td>
            <td>Tag</td>
            <td>Answer#1</td>
        </tr>
    </tbody>
</table>
<form action="/action_page.php">
    <select name="Sec" id="conSel">
        <option value="sec1">Activity</option>
        <option value="sec2">Quiz</option>
        <option value="sec3">Exam</option>
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
<body>
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

          dialog.close();
});
    </script>
</body>

<script>
        const conSel = document.getElementById('conSel');
        const tBody = document.getElementById('tBody');

        conSel.addEventListener('change', function() {
        const conSel = this.value;

      // Clear existing rows
      tBody.innerHTML = '';

      if (conSel === 'sec1') {
        tBody.innerHTML = `
        <tr>
            <td><input type="checkbox" /></td>
            <td>Activity#1</td>
            <td>Choice#1</td>
            <td>Answer#1</td>
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>Activity#2</td>
            <td>Choice#1</td>
            <td>Answer#1</td>
        </tr>
        `;

      }else if (conSel === 'sec2') {
      tBody.innerHTML = `
        <tr>
            <td><input type="checkbox" /></td>
            <td>Quiz#1</td>
            <td>Choice#1</td>
            <td>Answer#1</td>
      </tr>
      `;
       }else if (conSel === 'sec3') {
      tBody.innerHTML = `
        <tr>
          <td><input type="checkbox" /></td>
          <td>Exam#1</td>
          <td>Choice#1</td>
          <td>Answer#1</td>
      </tr>
      `;
      }
});
</script>


</body>
</html>