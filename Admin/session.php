<?php
        session_start();
        if (!isset($_SESSION['Id'])) {
            header("Location: index.php");
        }

    $Id_session=$_SESSION['Id'];
?>

<!---<?php
        session_start();
        if (!isset($_SESSION['SESSION_USER'])) {
            header("Location: index.php");
            die();
        }

        include 'config.php';

        $query = mysqli_query($conn, "SELECT * FROM admin WHERE uname='{$_SESSION['SESSION_USERNAME']}'");

        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);

          
        }
?>-->
