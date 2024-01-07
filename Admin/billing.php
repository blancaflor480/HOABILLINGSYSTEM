
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
	<span style="font-size:30px;cursor:pointer; color: #272c4a; font-weight: 600;" class="nav"  >☰ Billing</span>
	<span style="font-size:30px;cursor:pointer; color: #272c4a; font-weight: 600;" class="nav2"  >☰ Billing</span>
	</div>
		
		<div class="clearfix"></div>
	</div>

		<div class="clearfix"></div>
		<br/>
		
		
		
		<div class="clearfix"></div>
		
<?php 
include 'config.php';
$query = mysqli_query($conn, "SELECT * FROM users");
?>

		<div class="col-div-8" style="width: 100%;">
			<div class="box-8">
			<div class="content-box">
				
				<p>All Customers Transaction <span><input type="text" id="search" placeholder="Search" /></span></p>
				<br/>
				<table>
	  <tr>
	  	<th>Transaction ID</th>
	    <th>Name</th>
	    <th>Gender</th>
	    <th>Contact</th>
	    <th>Email</th>
		<th>Address</th>
	    <th>Due Date</th>
	    <th>Action</th>
	  </tr>
	  <?php
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $row['transaction_Id'] . "</td>"; // Adjust 'contact' based on your actual column name
                    echo "<td>" . $row['fname'] . "" . $row['lname'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>"; // Adjust 'contact' based on your actual column name
                    echo "<td>" . $row['contact'] . "</td>"; // Adjust 'contact' based on your actual column name
                    echo "<td>" . $row['email'] . "</td>"; // Adjust 'contact' based on your actual column name
					echo "<td>" . $row['address'] . "</td>"; // Adjust 'address' based on your actual column name
                    echo '<td><button type="button" class="btn btn-warning"><i class="fa fa-eye" aria-hidden="true"></i>	</button></td>';
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