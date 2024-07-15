<?php
include "admin_navbar.php";
require "../connection.php";

date_default_timezone_set('Asia/Kolkata');
$dt=date("Y-m-d H:i:s");

if(isset($_POST['setFeesBtn'])){
    $fees = $_POST['fees'];
    $set_fees_query ="update fees set fees = '$fees', set_time = '$dt'";
    mysqli_query($con, $set_fees_query);
    if($con->affected_rows > 0){
        echo "<script>alert('Fees Updated Successfully')</script>";
    }else{
        echo "<script>alert('Something went wrong try again later.')</script>";
    }
}

?>

<div class="container mt-5 p-5 shadow">
    <h1 class="text-primary pb-5">Welcome Admin</h1>

    <?php


    $gender = array( 
        array("label"=>"Male", "y"=>51.7),
        array("label"=>"Female", "y"=>26.6),
    );

    $get_fees_query = "select *from fees limit 1";
    $fees = mysqli_query($con, $get_fees_query)->fetch_assoc();
    if($con->affected_rows > 0){
    echo "<p class='text-success fs-3'>Current Fees <b><u>".$fees['fees']."  ₹</u></b> Updated at <b><u>".date("d-M-Y H:i", strtotime($fees['set_time']))."</u></b></p>";
    }?>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card border-info mb-3" onclick="location.href = 'visitors.php'" style="max-width: 23rem; cursor: pointer">
                <div class="card-header">Visitors</div>
                <div class="card-body text-info">
                    <h5 class="card-title">All Visitors Profile</h5>
                    <p class="card-text">See your all visitors with their complete profile and if you want; then you can delete the User</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-success mb-3" style="max-width: 23rem; cursor: pointer" data-bs-toggle="modal" data-bs-target="#setFees_Modal">
                <div class="card-header">Fees</div>
                <div class="card-body text-success">
                    <h5 class="card-title">Manage Fees</h5>
                    <p class="card-text">Manage <b>Visiting Fees</b> for per visitor. Fees should be in <b>Rupees (₹)</b> only.</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-dark mb-3" onclick="location.href = 'slots.php'" style="max-width: 23rem; cursor: pointer">
                <div class="card-header">Slots</div>
                <div class="card-body text-info">
                    <h5 class="card-title">Manage Slots</h5>
                    <p class="card-text">As per requirement / holidays Manage and Schedule slots with particular date</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-info mb-3" onclick="location.href = 'bookings.php'" style="max-width: 23rem; cursor: pointer">
                <div class="card-header">Bookings</div>
                <div class="card-body">
                    <h5 class="card-title">Booking Details</h5>
                    <p class="card-text">See all bookings details. Search booking by <b>booking Id</b></p>
                </div>
            </div>
        </div>   
        <div class="col">
            <div class="card border-warning mb-3" onclick="location.href = 'security_registration.php'" style="max-width: 23rem; cursor: pointer">
                <div class="card-header">Security</div>
                <div class="card-body text-warning">
                    <h5 class="card-title">Add Security</h5>
                    <p class="card-text">Add Security for Visitor check in check out .</p>
                </div>
            </div>
        </div>        
        
    </div>
</div>

<!-- Set Fees Modal -->
<div class="modal fade" id="setFees_Modal" tabindex="-1" aria-labelledby="setFees_ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="setFees_ModalLabel">Set Fees Per Visitor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-floating mb-5">
                <input type="number" name="fees" id="fees" required class="form-control">
                <label for="feea">Set Fees in ₹</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="setFeesBtn" class="btn btn-primary">Set Fees</button>
            </div>
        </form>
      </div>      
    </div>
  </div>
</div>