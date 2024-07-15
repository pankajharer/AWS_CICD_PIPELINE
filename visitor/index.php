<?php 
    include "visitor_navbar.php"; 
    require "../connection.php";     
?>


<div class="container shadow mt-5">
    <div class="row row-cols-1 row-cols-md-3 g-5">
    <div class="col">
            <div class="card text-white bg-success mb-3" onclick="location.href = 'booking.php'" style="max-width: 23rem; cursor: pointer">
                <div class="card-header">Book Now</div>
                <div class="card-body">                    
                    <h5 class="card-title">Current Fees Per Visitor.</h5>
                    <p class="card-text"><?php echo $fees['fees']; ?> ₹ Per Visitor</p>
                    <button class="btn btn-sm btn-outline-light">Book Now</button>
                </div>
            </div>
        </div>     
        <div class="col">
            <div class="card text-white bg-info mb-3" id="mv" style="max-width: 23rem; cursor: pointer">
                <div class="card-header">Verification</div>
                <div class="card-body">
                    <p class="card-text">Email Verification Status.</p>                    
                    <h5 class="pb-3">Email ID : Verified</h5>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-secondary mb-3" style="max-width: 23rem; cursor: pointer" data-bs-toggle="modal" data-bs-target="#showProfileModal">
                <div class="card-header">Profile</div>
                <div class="card-body">
                    <h5 class="card-title">Edit</h5>
                    <p class="card-text">See your Profile, Update if you want any changes.</p>
                </div>
            </div>
        </div>
           
        <div class="col">
            <div data-bs-toggle="modal" data-bs-target="#historyModal" class="card text-dark bg-warning mb-3" style="max-width: 23rem; cursor: pointer">
                <div class="card-header">History</div>
                <div class="card-body">
                    <h5 class="card-title">Booking History</h5>
                    <p class="card-text">Check your booking history in detail.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Show Profile Modal -->
    <div class="modal fade" id="showProfileModal" tabindex="-1" aria-labelledby="showProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showProfileModalLabel"><?php echo $_SESSION['visitor']['visitor_fname']. " ". $_SESSION['visitor']['visitor_lname']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>Vistor ID</th>
                        <td><?php echo $_SESSION['visitor']['visitor_id']; ?></td>
                    </tr>
                    <tr>
                        <th>ID Proof</th>
                        <td><?php echo $_SESSION['visitor']['visitor_id_proof']; ?></td>
                    </tr>
                    <tr>
                        <th>ID Image</th>
                        <td>
                        <img class="rounded mx-auto w-75" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($_SESSION['visitor']['visitor_id_proof_img']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?php echo $_SESSION['visitor']['visitor_fname']. " ".$_SESSION['visitor']['visitor_lname']; ?></td>
                    </tr>
                    <tr>
                        <th>Email ID</th>
                        <td><?php echo $_SESSION['visitor']['visitor_email']; ?></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><?php echo $_SESSION['visitor']['visitor_passwd']; ?></td>
                    </tr>
                    <tr>
                        <th>Reg Time</th>
                        <td><?php echo (date("d-M-Y H:i", strtotime($_SESSION['visitor']['reg_time']))) ?></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="location.href = 'update_profile.php'" class="btn btn-success" data-bs-dismiss="modal">Update</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
</div>


<!-- History Modal -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="historyModalLabel">Booking History</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        $visitor_id = $_SESSION['visitor']['visitor_id'];
            $get_history_query = "select booking_id, slot_id, book_time from bookings where visitor_id = '$visitor_id' order by book_time desc";
            $histories = mysqli_query($con, $get_history_query);
            if($con->affected_rows > 0){
            ?>
            <div class="table-responsive">
                <table class="table table-hover">
                        <tr class="bg-warning">
                            <th>Booking ID</th>
                            <th>Slot ID</th>
                            <th>Book Time</th>
                        </tr>
                        <?php
                        while($history = $histories->fetch_assoc()){
                            ?>
                            <tr>
                                <td><a target="__blank" href="../check_booking.php?id=<?php echo $history['booking_id']; ?>"><?php echo $history['booking_id']; ?></a></td>
                                <td><a target="__blank" href="../check_slot.php?slot_id=<?php echo $history['slot_id']; ?>"><?php echo $history['slot_id']; ?></a></td>
                                <td><?php echo date("d-M-Y h:i", strtotime($history['book_time'])); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                </table>
            </div>
            <?php
            }else{
                echo "No bookings yet..!!";
            }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>