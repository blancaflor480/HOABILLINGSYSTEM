<?php
session_start();

if (isset($_POST['change'])) {
    include 'config.php';

    $email = $_SESSION['email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['copassword'];

    // Fetch user data
    $stmt = $conn->prepare("SELECT * FROM tableusers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!$result) {
        echo '<script>alert("User not found"); window.location = "personalinfo.php";</script>';
        exit();
    }

    // Validate current password
    if ($result['password'] !== md5($current_password)) {
        echo '<script>alert("Incorrect current password"); window.location = "personalinfo.php";</script>';
        exit();
    }

    // Validate new password
    if (strlen($new_password) < 8) {
        echo '<script>alert("New password must be at least 8 characters"); window.location = "personalinfo.php";</script>';
        exit();
    }

    // Validate confirm password
    if ($new_password !== $confirm_password) {
        echo '<script>alert("New password and confirm password do not match"); window.location = "personalinfo.php";</script>';
        exit();
    }

    // Update password in the database
    $hashed_password = md5($new_password);
    $update_stmt = $conn->prepare("UPDATE tableusers SET password = ? WHERE email = ?");
    $update_stmt->bind_param("ss", $hashed_password, $email);
    $update_stmt->execute();

    echo '<script>alert("Password changed successfully"); window.location = "personalinfo.php";</script>';
    exit();
}
?>
