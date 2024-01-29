
<style>
  #staticBackdrop img {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
  }

  .modal-body {
    text-align: left;
  }

  .modal-body label {
    display: block;
    margin-bottom: 5px;
  }

  .modal-body input {
    width: 100%;
    padding: 6px;
    margin-bottom: 15px;
    box-sizing: border-box;
  }
  .modal-body select{
    width: 100%;
    padding: 6px;
    margin-bottom: 15px;
    box-sizing: border-box;
  }
</style>

<!-- Modal -->
<div class="modal fade" id="delete_account" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Restore Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <table class="table table-bordered" style="margin-left:0px;">
        <thead class="table-dark">
          <tr>
            <th style="width: 5%; font-size: 0.7rem;">#</th>           
            <th style="width: 20%; font-size: 0.7rem;">EMAIL ADDRESS</th>
            <th style="width: 10%; font-size: 0.7rem;">POSITION</th>
            <th style="width: 10%; font-size: 0.7rem;">RESTORE</th>
          
          </tr>
        </thead>
        <tbody>
       <?php
       $db = mysqli_connect("localhost", "root", "", "billing");
          $cmd = mysqli_query($db, "SELECT Id,email,type from tablearchives where type BETWEEN 'Admin' AND 'Staff' order by Id DESC");
          while ($result = mysqli_fetch_assoc($cmd)) {
            $id = $result["Id"];
            
              echo "<tr>";
              echo "<td>" . $result['Id'] . "</td>";
              
              echo "<td>" . $result['email'] . "</td>";
              echo "<td>" . $result['type'] . "</td>";
              echo '<td>
                          <form method="post" class="text-center">
                              <button class="btn form-control btn-outline-dark text-dark w-75" type="submit" name="insert" value="' . $result['Id'] . '"> <i class="bx bx-user-plus"></i></button>
                          </form>
                          </td>';
                
              echo "</tr>";
            }
       ?>
       </tbody>
      </table>
   
    </div>
  </div>
</div>
<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['insert'])) {
        $buttonValue = $_POST['insert'];

        // Check if the record already exists in the main table to avoid primary key conflicts
        $checkQuery = "SELECT * FROM tableaccount WHERE Id = '$buttonValue'";
        $checkResult = mysqli_query($db, $checkQuery);

        if (mysqli_num_rows($checkResult) == 0) {
            // The record does not exist in the main table, proceed with restoration
            $archiveQuery = "INSERT INTO tableaccount SELECT Id, fname, mname, lname, gender, contact, email, bday, address, uname, password, copassword, image, type, status, date_created, code FROM tablearchives WHERE Id = '$buttonValue'";
            $result1 = mysqli_query($db, $archiveQuery);

            if ($result1) {
                // Delete the record from the archive table after successful restoration
                $deleteQuery = "DELETE FROM tablearchives WHERE Id = '$buttonValue'";
                $deleteResult = mysqli_query($db, $deleteQuery);

                if ($deleteResult) {
                    echo '<script>setTimeout(function() { window.location.href = "accounts.php"; }, 10);</script>';
                } else {
                    echo "Error deleting record from archive table: " . mysqli_error($db);
                }
            } else {
                echo "Error restoring record to main table: " . mysqli_error($db);
            }
        } else {
            echo "Record already exists in the main table.";
        }
    }
}
?>
