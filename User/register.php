<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: welcome.php");
    die();
}

// Load Composer's autoloader
require 'vendor/autoload.php';

include 'config.php';
$msg = "";

if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tableusers WHERE email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$email} - This email address has been already exists.</div>";
    } else {
        if (strlen($password) >= 8 && $password === $confirm_password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO tableusers (fname, mname, lname, email, password, code) VALUES ('{$fname}', '{$mname}', '{$lname}', '{$email}', '{$hashedPassword}', '{$code}')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'billinghoa@gmail.com';                // SMTP username
                    $mail->Password   = 'sqtrxkdxrkbalgfu';                    // SMTP password
                    $mail->SMTPSecure = 'ssl';                                 // Enable implicit TLS encryption
                    $mail->Port       = 465;                                   // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    // Recipients
                    $mail->setFrom('billinghoa@gmail.com');
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'no reply';
                    $mail->Body    = 'Here is the verification link <b><a href="http://localhost/HOABILLINGSYSTEM/User/?verification='.$code.'">http://localhost/login/?verification='.$code.'</a></b>';

                    $mail->send();
                    $msg = "<div class='alert alert-info'>We've sent a verification link to your email address.</div>";
                } catch (Exception $e) {
                    $msg = "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Something went wrong.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password must be at least 8 characters and Confirm Password must match.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>HOA | Login Form</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!--<link rel="stylesheet" href="fonts/font-awesome.min.css">-->
    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                <a href="../Homepage.php">        
                <div class="alert-close" style="background-color: #182061">
                        <span class="fa fa-close"></span>
                    </div>
                </a>
                    <div class="w3l_form align-self" style="background-color: #182061">
                        <div class="left_grid_info">
                            <img src="images/image2.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Register Now</h2>
                        <p>To keep connected with us please login with your personal info</p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                          <label style="font-size: 1rem; font-weight: 450;">First name</label>
                            <input type="text"  class="name" name="fname" placeholder="Enter your first name" value="<?php if (isset($_POST['submit'])) { echo $fname; } ?>" required>
                            <label style="font-size: 1rem; font-weight: 450;">Middle name</label>
                             <input type="text" class="name" name="mname" placeholder="Enter your middle name" value="<?php if (isset($_POST['submit'])) { echo $mname; } ?>" required>
                             <label style="font-size: 1rem; font-weight: 450;">Last name</label>
                              <input type="text" class="name" name="lname" placeholder="Enter your last name" value="<?php if (isset($_POST['submit'])) { echo $lname; } ?>" required>
                            <label style="font-size: 1rem; font-weight: 450;">Email</label>
                            <input type="email" class="email" name="email" placeholder="Enter your email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                            <label style="font-size: 1rem; font-weight: 450;">Password</label>
                            <input type="password" class="password" name="password" placeholder="Enter your password" required>
                            <label style="font-size: 1rem; font-weight: 450;">Confirm</label>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter confirm password" required>
                            <button name="submit" class="btn" type="submit" style="background-color: #182061">Register</button>
                        </form>
                        <div class="social-icons">
                            <p>Have an account! <a href="index.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>