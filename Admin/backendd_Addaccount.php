<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Form data
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $uname = $_POST['uname'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Image upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["pfp"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["pfp"]["tmp_name"]);
    if ($check === false) {
        die("Error: File is not an image.");
    }

    if (file_exists($target_file)) {
        die("Error: Sorry, the file already exists.");
    }

    if ($_FILES["pfp"]["size"] > 500000) {
        die("Error: Sorry, your file is too large.");
    }

    $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_extensions)) {
        die("Error: Sorry, only JPG, JPEG, PNG, and GIF files are allowed.");
    }

    if (move_uploaded_file($_FILES["pfp"]["tmp_name"], $target_file)) {
        $type = $_POST['type'];
        // Insert user information into the database using prepared statements
        $stmt = $conn->prepare("INSERT INTO tableaccount (fname, mname, lname, email, gender, uname, password, image, type) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssssss", $fname, $mname, $lname, $email, $gender, $uname, $password, $target_file, $type);

        if ($stmt->execute()) {
            echo '<script>alert("Created successfully!")</script>';
        } else {
            die("Error: " . $stmt->error);
        }

        $stmt->close();
    } else {
        die("Error: Sorry, there was an error uploading your file.");
    }

    // Close database connection
    $conn->close();

    // Redirect after processing the form
    header("Location: account.php");
    exit();
}
?>
