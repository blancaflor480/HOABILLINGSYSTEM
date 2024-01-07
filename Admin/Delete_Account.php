
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
            <th style="width: 10%; font-size: 0.7rem;">RESTORE</th>
          </tr>
        </thead>
        <tbody>
       <?php
       $db = mysqli_connect("localhost", "root", "", "billing");
          $cmd = mysqli_query($db, "SELECT Id,email from tableaccount where type ='Staff' and  status='offline' order by Id DESC");
          while ($result = mysqli_fetch_assoc($cmd)) {
            $id = $result["Id"];
            
              echo "<tr>";
              echo "<td>" . $result['Id'] . "</td>";
              
              echo "<td>" . $result['email'] . "</td>";
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
include ('config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['insert'])) {
        $buttonValue = $_POST['insert'];
        $sql = "UPDATE tableaccount set status='Active' WHERE Id = '$buttonValue'";
        $result1 = mysqli_query($db,$sql);
        if($result1)
        {
         
          echo '<script>setTimeout(function() { window.location.href = "accounts.php"; }, 10);</script>';
        }
       
    }
}
?>