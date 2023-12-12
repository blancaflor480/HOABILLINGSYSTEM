<!Doctype HTML>
	<html>
	<head>
		<title>Slide</title>
		<link rel="stylesheet" href="css/slidestyle.css" type="text/css"/>
		<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		-->
		<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
	</head>


	<body>
		
	  <div id="mySidenav" class="sidenav" style="background-color: #182061;">
	  <p class="logo"><span>E</span>-Billing</p>
	  <a href="dashboard.php" class="icon-a"><i class="fa fa-dashboard icons"></i>   Dashboard</a>
	  <a href="customer.php"class="icon-a"><i class="fa fa-users icons"></i>   Customers</a>
	  <!--<a href="#"class="icon-a"><i class="fa fa-list icons"></i>   Projects</a>-->
	  <a href="billing.php"class="icon-a"><i class="fa fa-tasks icons"></i>   Billing</a>
	  <a href="accounts.php"class="icon-a"><i class="fa fa-user icons"></i>   Accounts</a>
	  <a href="complaint.php"class="icon-a"><i class="fa fa-list-alt icons"></i>   Complaints</a>
	  <br><br>
	  <a href="logout.php"class="icon-a"><i class="fa fa-power-off icons"></i>   Logout</a>
	  

	</div>
	<!---<div class="col-div-6">
	<span style="font-size:30px;cursor:pointer; color: white;" class="nav"  >☰ Dashboard</span>
	<span style="font-size:30px;cursor:pointer; color: white;" class="nav2"  >☰ Dashboard</span>
	</div>-->
		
		<!--<div class="col-div-6">
		<div class="profile">

			<img src="images/user.png" class="pro-img" />
			<p>Manoj Adhikari <span>UI / UX DESIGNER</span></p>
		</div>-->
	<!--</div>
		<div class="clearfix"></div>
	</div>-->

		

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