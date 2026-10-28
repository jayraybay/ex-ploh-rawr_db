    <!DOCTYPE html>
    <html><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="nav_admin_files\nav_admin_Q1GJ.css">
    <link href="nav_admin_files\boxicons.min_Q1GJ.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="teacher_acc.css"/>

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
            <th class="name">Name</th>
            <th class="teacher_acc">Account</th>
            <th class="pass">Password</th>
            <th class="sel"></th>
        </tr>
    </thead>
    <tbody>
        <tr data-href="content_reset.php">
            <td>Teacher#1</td>
            <td>teacher.acc@gmail.com</td>
            <td>Password</td>
            <td><input type="checkbox"></td>
        </trdata-href>
    </tbody>
    <tbody>
        <tr data-href="content_reset.php">
            <td>Teacher#1</td>
            <td>teacher.acc@gmail.com</td>
            <td>Password</td>
            <td><input type="checkbox"></td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="content_reset.php">
            <td>Teacher#1</td>
            <td>teacher.acc@gmail.com</td>
            <td>Password</td>
            <td><input type="checkbox"></td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="content_reset.php">
            <td>Teacher#1</td>
            <td>teacher.acc@gmail.com</td>
            <td>Password</td>
            <td><input type="checkbox"></td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="content_reset.php">
            <td>Teacher#1</td>
            <td>teacher.acc@gmail.com</td>
            <td>Password</td>
            <td><input type="checkbox"></td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="content_reset.php">
            <td>Teacher#1</td>
            <td>teacher.acc@gmail.com</td>
            <td>Password</td>
            <td><input type="checkbox"></td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="content_reset.php">
            <td>Teacher#1</td>
            <td>teacher.acc@gmail.com</td>
            <td>Password</td>
            <td><input type="checkbox"></td>
        </tr>
    </tbody>
    <tbody>
        <tr data-href="content_reset.php">
            <td>Teacher#1</td>
            <td>teacher.acc@gmail.com</td>
            <td>Password</td>
            <td><input type="checkbox"></td>
        </tr>
    </tbody>
</table>

<div class="search">
    <input type="text" placeholder="Please enter name" required />
</div>

<div class="reset">
    <button type="button">Reset Password</button>
</div>

<div class="create">
    <button onclick="document.location='Tcreate_acc.php'">Create Account</button>
</div>

    </main>

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


</html>