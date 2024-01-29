<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: index.php?error=Login%20First");
        die();
    }

    include 'config.php';

	$email = $_SESSION['email'];
	$conn_String = mysqli_connect("localhost", "root", "", "billing");
	$stmt = $conn_String->prepare("SELECT * FROM tableusers WHERE email = '{$_SESSION['email']}'");
	$stmt->execute();
	$result = $stmt->get_result()->fetch_assoc();
	
	if (!$result) {
		header("Location: index.php?error=Login%20First");
		exit();
	}


//    $query = mysqli_query($conn, "SELECT * FROM tableusers WHERE email='{$_SESSION['SESSION_EMAIL']}'");

  //  if (mysqli_num_rows($query) > 0) {
    //    $row = mysqli_fetch_assoc($query);

       // echo "Welcome " . $row['fname'] . " <a href='logout.php'>Logout</a>";
    //}
?>
<?php include('Sidebar.php');?>

<!-- Include these links to the head section of your HTML -->
<link rel="stylesheet" type="text/css" href="DataTables-1.13.8/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/js/jquery.dataTables.js"></script>

<style>
  .card {
    margin: 0px;
  }

  .table th,
  .table td {
    text-align: center;
    vertical-align: middle;
    font-size: 14px; /* Adjusted font size */
  }

  .table img {
    max-width: 80px;
    max-height: 80px;
    border: 4px groove #CCCCCC;
    border-radius: 5px;
  }

  .dropdown-menu a {
    cursor: pointer;
    font-size: 15px; /* Adjusted font size */
  }

  .dropdown-menu a:hover {
    background-color: #f8f9fa !important;
  }

  .btn {
    font-size: 12px; /* Adjusted font size */
  }

  /* Adjusted font size for DataTable controls */
  .dataTables_length,
  .dataTables_filter,
  .dataTables_info,
  .paginate_button {
    font-size: 12px;
  }

  /* Adjusted font size for pagination buttons */
  .paginate_button.previous, .paginate_button.next {
    font-size: 12px;
  }
</style>

 <section class="home-section">
<div class="text">Billing</div>
    <div class="col-lg-12">
        <div class="card">
          <h5 class="card-header">Dues Bills
              <a class="btn btn-primary float-right mx-2" href="billing_history.php">
                <span class="bi bi-receipt"></span> History Transaction
              </a>
              <a class="btn btn-warning float-right" href="complaint.php">
                <span class="bx bx-envelope"></span> Compalint
              </a>
           </h5>
          <div class="card-body">
            <table class="table table-hover table-striped table-bordered" id="list">
              <thead>
                <tr>
                <th>Bill no.</th>
                  <th>Reading Date</th>
                  <th>Due Date</th>
                  <th>Current Amount</th>
                  <th>Penalties</th>
                  <th>Service Fee</th>
                  <th>Previous</th>
                  <th>Amount</th>
				          <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                 $i = 1;
                $email = $_SESSION['email']; // Get the email of the logged-in user
                $qry = $conn->prepare("SELECT b.*, concat(c.lname, ', ', c.fname, ' ', coalesce(c.mname,'')) as `name` 
                          FROM `tablebilling_list` b 
                          INNER JOIN tableusers c ON b.tableusers_id = c.id 
                          WHERE c.email = ? AND b.status = 0 
                          ORDER BY unix_timestamp(`reading_date`) DESC, `name` ASC ");
                $qry->bind_param("s", $email);
                $qry->execute();
                $result = $qry->get_result();

             while($row = $result->fetch_assoc()):
?>
					
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['reading_date'])); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['due_date'])); ?></td>
                    <td><?php echo $row['reading']; ?></td>
                    <td><?php echo $row['penalties']; ?></td>
                    <td><?php echo $row['service']; ?></td>
                    <td><?php echo $row['previous']; ?></td>
                    <td><b><?php echo $row['total']; ?></b></td>
                    <td>
                    <?php
								  switch($row['status']){
									case 0:
										echo '<span class="badge badge-danger  bg-gradient-danger text-lg px-3" Style="Height: 20px; font-size: 0.7rem;">
                                PENDING</span>';
                    break;
									case 1:
										echo '<span class="badge badge-success bg-gradient-success text-sm px-3 ">Paid</span>';
										break;
								}
								?>
                    </td>
<td>
  <button class="btn btn-success" data-toggle="modal" data-target="#paymentModal">Pay</button>
</td>
                  </tr>
                <?php endwhile ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
   
</section>


<script>
  $(document).ready(function () {
    $('#list').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [5, 10, 25, 50, 75, 100],
      "pageLength": 10,
      "order": [[1, 'desc']],
    });
  });
</script>
<!-- Bootstrap Modal for Payment Options -->

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">Choose Payment Method</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Add your payment options here -->
        <div style="margin: auto; background-color: yellow;">
        <div class="col-md-6" style="margin-left: 150px">
        <button class="btn btn-primary" onclick="payWithGCash()">Pay with GCash</button>
        </div><br>
        <div class="col-md-6" style="margin-left: 145px">
        <button class="btn btn-success" onclick="payWithPayMaya()">Pay with PayMaya</button>
      </div>
      </div>
      </div>
    </div>
  </div>
</div>
<script>
  function payWithGCash() {
    // Implement GCash payment logic here
    alert('Redirecting to GCash payment page');
    // You can add the actual logic to redirect to GCash payment page or perform other actions.
  }

  function payWithPayMaya() {
    // Implement PayMaya payment logic here
    alert('Redirecting to PayMaya payment page');
    // You can add the actual logic to redirect to PayMaya payment page or perform other actions.
  }
</script>
