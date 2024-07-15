<?php
require "admin_navbar.php";

require "../connection.php";


date_default_timezone_set('Asia/Kolkata');
$dt=date("Y-m-d H:i:s");

if(isset($_POST['approve'])){

    $id = $_POST['approve'];
    $chk_approve_query = "select *from visitor_approval where visitor_id = '$id'";
    $visitor = mysqli_query($con, $chk_approve_query)->fetch_assoc();
    if($con->affected_rows > 0){        
        if($visitor['approval_status'] == "approved"){
            echo "<script>alert('Profile Already Approved..')</script>";
        }else{
            $update_status_query = "update visitor_approval set approval_status = 'approved', approval_reason = 'NA', approval_time = '$dt' where visitor_id = '$id'";
            mysqli_query($con, $update_status_query);
            if($con->affected_rows > 0){
                echo "<script>alert('Profile Approved Successfully..!')</script>";    
            }else{
                echo "<script>alert('Something went wrong try again..!')</script>";
            }
        }
    }else{        
        $approve_query = "insert into visitor_approval (visitor_id, approval_status, approval_reason, approval_time) 
                            values('$id', 'approved', 'NA', '$dt')";
        mysqli_query($con, $approve_query);
        if($con->affected_rows > 0){
            echo "<script>alert('Profile Approved Successfully..!')</script>";
        }else{
            echo "<script>alert('Something went wrong try again..!')</script>";
        }
    }
}


if(isset($_POST['sendBack'])){
    $id = $_POST['visitor_id'];
    $reason = $_POST['sent_back_reason'];
    $chk_approve_query = "select *from visitor_approval where visitor_id = '$id'";
    $visitor = mysqli_query($con, $chk_approve_query)->fetch_assoc();
    if($con->affected_rows > 0){
        $update_status_query = "update visitor_approval set approval_status = 'disapproved', approval_reason = '$reason', approval_time = '$dt' where visitor_id = '$id'";
        mysqli_query($con, $update_status_query);
        if($con->affected_rows > 0){
            echo "<script>alert('Profile Sent Back Successfully..!')</script>";
        }else{
            echo "<script>alert('Something went wrong try again..!')</script>";
        }
    }else{
        $approve_query = "insert into visitor_approval (visitor_id, approval_status, approval_reason, approval_time) 
                            values('$id', 'disapproved', '$reason', '$dt')";
        mysqli_query($con, $approve_query);
        if($con->affected_rows > 0){
            echo "<script>alert('Profile Sent Back Successfully..!')</script>";
        }else{
            echo "<script>alert('Something went wrong try again..!')</script>";
        }
    }
}

$get_visitor_query = "select *from visitors where (visitor_country = 'India' and evs = 'Active' and mvs = 'Active') or (evs = 'Active') order by reg_time";
$visitors = mysqli_query($con, $get_visitor_query);
if($con->affected_rows > 0){
?>
    <p class="text-info m-4 fs-5"><b>India : Verified Email and Phone <br>Other Countries : Verified Email</b></p>
    <div class="table-responsive table-responsive-lg m-2">
        <table class="table table-hover">
            <tr class="bg-light">
                <th>Visitor ID</th>
                <th>Country</th>
                <th>Name</th>
                <th>ID Proof</th>
                <th>Proof Image</th>
                <th>Status</th>
                <th>Remark</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>Address</th>
                <th>Email</th>
                <th>Password</th>
                <th>Phone</th>
            </tr>
            <?php
            while($visitor = $visitors->fetch_assoc()){
                ?>
                <tr>
                    <td><?php echo $visitor['visitor_id']; ?></td>
                    <td><?php echo $visitor['visitor_country']; ?></td>
                    <td><?php echo $visitor['visitor_fname']." ".$visitor['visitor_mname']. " ". $visitor['visitor_lname']; ?></td>
                    <td><?php echo $visitor['visitor_id_proof']; ?></td>
                    <?php
                        $status = '';
                        $id = $visitor['visitor_id'];
                        $chk_approve_query = "select *from visitor_approval where visitor_id = '$id'";
                        $return_status = mysqli_query($con, $chk_approve_query)->fetch_assoc();
                        if($con->affected_rows > 0){
                            if($return_status['approval_status'] == "approved"){
                                $status = 'Approved';
                            }else{
                                $status = "Sent Back";
                            }
                        }else{
                            $status = "Pending";
                        }
                    ?>
                    <td  data-bs-img="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($visitor['visitor_id_proof_img']); ?>" data-bs-toggle="modal" data-bs-target="#id_proof_img_Modal"><p class="text-info" style="cursor:pointer;">Show <i class="fa fa-eye"></i></p></td>
                    <td>
                        <?php echo $status; ?>
                    </td>                
                    <td class="row g-3">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="col">
                            <button class="btn btn-outline-success" name="approve" value="<?php echo $visitor['visitor_id']; ?>" title="Approve"><i class="fa fa-check"></i></button>
                        </form>
                        <div class="col">
                            <button class="btn btn-outline-danger" title="Not Approve" data-bs-visitor_id="<?php echo $visitor['visitor_id']; ?>" data-bs-toggle="modal" data-bs-target="#sendBack_Modal" style="cursor:pointer;"><i class="fa fa-xmark"></i></button>
                        </div>
                    </td>
                    <td><?php echo $visitor['visitor_gender']; ?></td>
                    <td><?php echo $visitor['visitor_dob']; ?></td>
                    <td><?php echo $visitor['visitor_address']; ?></td>
                    <td><?php echo $visitor['visitor_email']; ?></td>
                    <td><?php echo $visitor['visitor_passwd']; ?></td>
                    <td><?php echo $visitor['visitor_mob_no']; ?></td>
                </tr>
                <?php
            }
            ?>
            <div class="modal fade" id="id_proof_img_Modal" tabindex="-1" aria-labelledby="id_proof_img_ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="id_proof_img_ModalLabel"></h5>
                            <button typed="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img class="rounded mx-auto w-100" src="" alt="ID Proof Image">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="sendBack_Modal" tabindex="-1" aria-labelledby="sendBack_ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="sendBack_ModalLabel"></h5>
                            <button typed="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                <div class="mb-3 form-floating">
                                    <input type="text" name="visitor_id" id="visitor_id" class="form-control" readonly />
                                    <label for="visitor_id">Visitor ID</label>
                                </div>
                                <div class="mb-3 form-floating">
                                    <input maxlength="150" name="sent_back_reason" id="sent_back_reason" class="form-control" required/>
                                    <label for="sebd_back_reason">State the reason for sent back.</label>
                                    <p class="text-info">150 characters are allowed.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="sendBack" class="btn btn-primary">Send Back</button>
                                </div>  
                            </form>
                        </div>                    
                    </div>
                </div>
            </div>
        </table>
        <script>
            
            //  Enlarge Image

            var id_proof_img_Modal = document.getElementById('id_proof_img_Modal')
            id_proof_img_Modal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var id_proof_img = button.getAttribute('data-bs-img')
            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            var modalTitle = id_proof_img_Modal.querySelector('.modal-title')
            var modalBodyImg = id_proof_img_Modal.querySelector('.modal-body img')

            modalTitle.textContent = "ID Proof Image"
            modalBodyImg.src = id_proof_img
            })


            //  Send Back Profile

            var sendBack_Modal = document.getElementById('sendBack_Modal')
            sendBack_Modal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var id = button.getAttribute('data-bs-visitor_id')
            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            var modalTitle = sendBack_Modal.querySelector('.modal-title')
            var visitor_id = document.getElementById("visitor_id");
            visitor_id.value = id

            modalTitle.textContent = "Send Back for Updation"        
            })
        </script>
    </div>

<?php
}else{
?>
    <h3 class="container mt-5 p-5 shadow text-info">No Visitor Registered Yet..!!</h3>
<?php
}
?>