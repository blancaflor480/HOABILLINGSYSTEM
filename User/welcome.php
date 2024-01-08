<?php
    session_start();
    if (!isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: index.php");
        die();
    }

    include 'config.php';

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);

        echo "Welcome " . $row['fname'] . " " . $row['lname'] ." <a href='logout.php'>Logout</a>";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
</head>
<body>
    <h1 style="text-align: center; ">UNDER MAINTENANCE.</h1>
<!--<form action="" method="post">
    <div>
        <label>First Name: <input type="text" name="fname"/></label><br>
        <label>Middle Name: <input type="text" name="mname"/></label><br>
        <label>Last Name: <input type="text" name="lname" /></label><br>
        <label>Email: <input type="email" name="email" /></label><br>
        <label>Birth Day: <input type="date" name="bday"/></label><br>
        <select type="text" name="gender">Please Select</select>
        <option></option>
        </div>
</form>-->
</body>
</html>