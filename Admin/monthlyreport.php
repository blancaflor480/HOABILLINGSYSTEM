
<?php
session_start();
include('config.php');
include('Sidebar.php');

if (isset($_SESSION['uname'])) {
    $uname = $_SESSION['uname'];
} else {
    // Handle the case when the session variable is not set, redirect or show an error.
    header("Location: index.php");
    exit();
}

$query  = mysqli_query($conn, "SELECT * FROM tableaccount WHERE uname = '$uname'") or die(mysqli_error());
$row = mysqli_fetch_array($query);
$type  = $row['type'];

// Initialize $month to the current month
$month = isset($_GET['month']) ? $_GET['month'] : date("Y-m");

function format_num($number) {
    // Customize this function based on your formatting needs
    return number_format($number, 2); // Example: Format as a decimal with 2 decimal places
}

?>

<style>
  .card {
    margin: 0px;
  }

  .table th,
  .table td {
    text-align: center;
    vertical-align: middle;
    font-size: 15px; /* Adjusted font size */
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
.viewBillingBtn,
.editBillingBtn,
.deleteBillingBtn {
    font-size: 11px; /* Adjust the font size as needed */
    padding: 2px 5px; /* Adjust the padding as needed */
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


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>


<section class="home-section">
<div class="text">Monthly Rport</div>
<div class="col-lg-12">
<div class="card card-outline rounded-0 card-navy">
   <div class="card-body">
        <div class="container-fluid">
            <fieldset class="border mb-4">
                <legend class="mx-3 w-auto">Filter</legend>
                <div class="container-fluid py-2 px-3">
                    <form action="" id="filter-form">
                        <div class="row align-items-end">
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group m-0">
                                    <label for="month" class="control-label">Filter Month</label>
                                    <input type="month" id="month" name="month" value="<?= $month ?>" class="form-control form-control-sm rounded-0" required>

 
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <button class="btn btn-primary bg-gradient-primary rounded-0"><i class="fa fa-filter"></i> Filter</button>
                                <button class="btn btn-light bg-gradient-light rounded-0 border" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                               <button class="btn btn-light bg-gradient-light rounded-0 border" type="button" id="excel-export"><i class="fa fa-file-excel"></i> Excel Export</button>

                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>
        <div class="container-fluid" id="printout">
      <table class="table table-hover table-striped table-bordered" id="report-tbl">
                <colgroup>
                    <col width="5%">
                    <col width="10%">
                    <col width="10%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reading Date</th>
                        <th>Due Date</th>
                        <th>Homeowners Name</th>
                        <th>Reading</th>
                        <th>Penalty</th>
                        <th>Service</th>
                        <th>Status</th>
                        
                        <th>Amount</th>
                    </tr>
                </thead>
        <tbody>
          <?php 
          $i = 1;
          $qry = $conn->query("SELECT b.*, c.code, CONCAT(c.lname, ', ', c.fname, ' ', COALESCE(c.mname, '')) as `name` FROM `tablebilling_list` b INNER JOIN tableusers c ON b.tableusers_id = c.Id WHERE DATE_FORMAT(b.reading_date, '%Y-%m') = '{$month}' ORDER BY UNIX_TIMESTAMP(`reading_date`) DESC, `name` ASC");

          
          
              while($row = $qry->fetch_assoc()):
          ?>
             <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo date("Y-m-d",strtotime($row['reading_date'])) ?></td>
                            <td><?php echo date("Y-m-d",strtotime($row['due_date'])) ?></td>
                            <td>
                                <div style="line-height:1em">
                                    <div><?= ($row['name']) ?></div>
                                </div>
                            </td>
                            <td>
                                <div style="line-height:1em">
                                    <div><small class="text-muter">Previous: </small><?= format_num($row['previous']) ?></div>
                                    <div><small class="text-muter">Current: </small><?= format_num($row['reading']) ?></div>
                                </div>
                            </td>
                            <td class="text-center"><?php echo ($row['penalties']); ?></td>
                            <td class="text-center"><?= format_num($row['service']) ?></td>
                            <td class="text-center">
                                <?php
                                  switch($row['status']){
                                    case 0:
                                        echo '<span class="badge badge-danger  bg-gradient-danger text-lg px-3" Style="Height: 17px; font-size: 0.7rem;">
                                UNPAID</span>';
                    break;
                                    case 1:
                                        echo '<span class="badge badge-success bg-gradient-success text-sm px-3 " Style="Height: 17px; font-size: 0.7rem;">PAID</span>';
                                        break;
                                         case 2:
                                        echo '<span class="badge badge-warning bg-gradient-warning text-sm px-3 " Style="Height: 17px; font-size: 0.7rem;">PENDING</span>';
                                        break;
                                }
                                ?>
                            </td>
                            <td class="text-center"><?php echo format_num($row['total']) ?></td>
                        </tr>
          <?php endwhile; ?>
                    <?php if($qry->num_rows <= 0): ?>
                        <tr>
                            <th class="text-center" colspan="9" style="font-weight: 300;">No data available.</th>
                        </tr>
                    <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<noscript id="print-header">
  <div>
    <div class="d-flex w-100 align-items-center">
      <div class="col-2 text-center">
        <img src="images/rosedalelogo.png" alt=""  style="width:10em;height:5em;object-fit:cover;object-position:center center;">
      </div>
      <div class="col-8">
        <div style="line-height:1em">
          <h4 class="text-center">Rosedale Residence</h4>
          <h3 class="text-center">Monthly Billing Report</h3>
                    <div class="text-center">as of</div>
                    <h4 class="text-center"><?= date("F, Y",strtotime($month."-1"))  ?></h4>
        </div>
      </div>
    </div>
    <hr>
  </div>
</div>
</noscript>

</section>
<script>
$(document).ready(function () {
    $('#report-tbl td, #report-tbl th').addClass('py-1 px-2 align-middle');

    $('#filter-form').submit(function (e) {
        e.preventDefault();
        location.href = 'monthlyreport.php?' + $(this).serialize();
    });

    $('#print').click(function () {
        console.log("Button clicked");

        var h = $('head').clone();
        var p = $('#printout').clone();
        var ph = $($('noscript#print-header').html()).clone();

        var nw = window.open('', '_blank', 'width=' + ($(window).width() * .80) + ',height=' + ($(window).height() * .90) + ',left=' + ($(window).width() * .1) + ',top=' + ($(window).height() * .05));
        nw.document.querySelector("head").innerHTML = h.html();
        nw.document.querySelector("body").innerHTML = ph[0].outerHTML + p[0].outerHTML;
        nw.document.close();

        start_loader();
        setTimeout(() => {
            nw.print();
            setTimeout(() => {
                nw.close();
                end_loader();
            }, 300);
        }, 300);
    });
});
</script>   