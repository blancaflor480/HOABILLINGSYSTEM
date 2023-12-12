<?php
    session_start();
    if (!isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: index.php");
        die();
    }

    include 'config.php';

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE email='{$_SESSION['SESSION_EMAIL']}'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
    }
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Dashboard | Admin</title>
    <!--<link rel="stylesheet" href="css/style1.css" type="text/css"/>-->
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css" type="text/css"/>
    <script src="Bootstrap/bootstrap.min.js"></script>
</head>

<?php include('slide.php');?>

<body>

    <div id="main">

        <div class="head">
            <div class="col-div-6">
                <span style="font-size:30px;cursor:pointer; color: #272c4a; font-weight: 600;" class="nav">☰ Complaints</span>
                <span style="font-size:30px;cursor:pointer; color: #272c4a; font-weight: 600;" class="nav2">☰ Complaints</span>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>
        <br />

        <div class="clearfix"></div>
<?php 
                                            ?>
                                        
        
        <div class="col-div-8" style="width: 100%;">
            <div class="box-8">
                <div class="content-box">
                    <p>All Customers <span><input type="text" id="search" placeholder="Search" /></span></p>
                    <br />
                    <table>
                        <tr>
                            <th>Complaint No.</th>
                            <th>Transaction ID</th>
                            <th>Name of Customer</th>
                            <th>Complaint</th>
                            <th>Status</th>
                            <th>Process</th>
                        </tr>
                       <?php 
           //$query = mysqli_query($conn, "SELECT id, transaction_Id, fname, mname, lname, complaint, stats FROM complaint");

        //$query = mysqli_query($conn, "SELECT id, complaint, stats FROM complaint");
          $query = mysqli_query($conn, "SELECT complaint.id, users.transaction_Id, users.fname, users.lname ,complaint.complaint, complaint.stats
              FROM complaint
              LEFT JOIN users ON complaint.usersid = users.id
              LEFT JOIN users AS u1 ON complaint.id = u1.transaction_Id
              LEFT JOIN users AS u2 ON complaint.id = u2.fname
              LEFT JOIN users AS u3 ON complaint.id = u3.lname");
                       
           
           if (mysqli_num_rows($query) > 0) {
                // Your existing loop code here
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['transaction_Id'] . "</td>";
                    echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
                    echo "<td>" . $row['complaint'] . "</td>";
                    echo "<td>" . $row['stats'] . "</td>";
                    echo '<td><button type="button" class="btn btn-success">Response</button></td>';
                    echo "</tr>";
                }
            } else {
                echo "No complaints found";
            }
        ?>


                        <!-- The loop code is moved above -->
                    </table>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(".nav").click(function(){
            $("#mySidenav").css('width','70px');
            $("#main").css('margin-left','70px');
            $(".logo").css('visibility', 'hidden');
            $(".logo span").css('visibility', 'visible');
            $(".logo span").css('margin-left', '-10px');
            $(".icon-a").css('visibility', 'hidden');
            $(".icons").css('visibility', 'visible');
            $(".icons").css('margin-left', '-8px');
            $(".nav").css('display','none');
            $(".nav2").css('display','block');
        });

        $(".nav2").click(function(){
            $("#mySidenav").css('width','300px');
            $("#main").css('margin-left','300px');
            $(".logo").css('visibility', 'visible');
            $(".icon-a").css('visibility', 'visible');
            $(".icons").css('visibility', 'visible');
            $(".nav").css('display','block');
            $(".nav2").css('display','none');
        });
    </script>

</body>

</html>
