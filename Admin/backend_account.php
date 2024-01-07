<?php
 include('config.php');
 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){ 
    // Form data
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $bday = $_POST['bday'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $uname = $_POST['uname'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
   
    // Image upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["pfp"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["pfp"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        echo "Sorry, the file already exists.";
        $uploadOk = 0;
    }

    if ($_FILES["pfp"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload the file
        if (move_uploaded_file($_FILES["pfp"]["tmp_name"], $target_file)) {
            $type = $_POST['type'];
            // Insert user information into the database
            $sql = "INSERT INTO tableaccount (fname, mname, lname, email, contact, bday, address, gender, uname,password,image, type) 
                    VALUES ('$fname', '$mname', '$lname', '$email','$contact', '$bday','$address', '$gender', '$uname','$password', '$target_file', '$type')";

            if ($conn->query($sql) === TRUE) {
                echo "Account created successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Close database connection
    $conn->close();
}
?>