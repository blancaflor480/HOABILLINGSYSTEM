<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Form data
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $bday = $_POST['bday'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Image upload handling
    $target_dir = "uploads/";

    if (!empty($_FILES["pfp"]["name"])) {
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

        if (!move_uploaded_file($_FILES["pfp"]["tmp_name"], $target_file)) {
            die("Error: Sorry, there was an error uploading your file.");
        }
    } else {
        // If no profile image is provided, set a default path or handle it accordingly
        $target_file = "default_image.jpg";
    }

    
    // Insert user information into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO tableusers (fname, mname, lname, email, bday, address, gender, password, image) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssss", $fname, $mname, $lname, $email,  $bday,  $address, $gender, $password, $target_file);

    if ($stmt->execute()) {
        echo '<script>alert("Created successfully!")</script>';
        header("Location: customer.php");
        exit();
    } else {
        echo '<script>alert("Error, Please try again!")</script>';
        die("Error: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
