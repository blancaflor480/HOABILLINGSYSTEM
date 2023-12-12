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

       // echo "Welcome " . $row['fname'] . " <a href='logout.php'>Logout</a>";
    }
?>

<!Doctype HTML>
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
	<span style="font-size:30px;cursor:pointer; color: #272c4a; font-weight: 600;" class="nav"  >☰ Accounts</span>
	<span style="font-size:30px;cursor:pointer; color: #272c4a; font-weight: 600;" class="nav2"  >☰ Accounts</span>
	</div>
		
		<div class="clearfix"></div>
	</div>

		<div class="clearfix"></div>
		<br/>
		
		
		
		<div class="clearfix"></div>
		
<?php 
include 'config.php';
$query = mysqli_query($conn, "SELECT * FROM admin");
?>

		<div class="col-div-8" style="width: 100%;">
			<div class="box-8">
			<div class="content-box">
				<p>Administrator Account <span style="background-color: #272c4a;"><button type="button" class="btn btn-success"><i class="fa fa-plus-square" aria-hidden="true"></i> &nbsp Account</button></span></p>
				<br/>
				<table>
	  <tr>
	    <th>Name</th>
	    <th>Gender</th>
	    <th>Birthday</th>
	    <th>Contact</th>
	    <th>Address</th>
	    <th>Email</th>
	    <th>Type</th>
	    <th>Action</th>
	  </tr>
	  <?php
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>"; 
                    echo "<td>" . $row['bday'] . "</td>"; 
                    echo "<td>" . $row['contact'] . "</td>"; 
                    echo "<td>" . $row['address'] . "</td>"; 
                    echo "<td>" . $row['email'] . "</td>"; 
                    echo "<td>" . $row['type'] . "</td>";
                    echo '<td><button type="button" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>';
                    echo '<td><button type="button" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button></td>';         
                    echo "</tr>";
                }
                ?>	  
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