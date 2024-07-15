<?php
require "admin_navbar.php";
require "../connection.php";



if(isset($_POST['remove_id'])){
    $id = $_POST['remove_id'];
    $remove_query = "delete from visitors where visitor_id = '$id'";
    mysqli_query($con, $remove_query);
    if($con->affected_rows > 0){
        echo "<script>alert('Visitor Removed Successfully..!')</script>";
    }else{
        echo "<script>alert('Visitor Not Exist..!')</script>";
    }
}


// Get all visitors profile whose email and phone is verified (Non Indian dont require phone verification)
$get_visitor_query = "select *from visitors where evs = 'Active' order by reg_time";
$visitors = mysqli_query($con, $get_visitor_query);

?>

<h1 class="text-info m-4"><b>Email Verified Users</b></h1>
<div class="table-responsive">
    <table class="table table-hover">
    <tr class="bg-primary">
            <th>Visitor ID</th>
            <th>Action</th>
            <th>Name</th>
            <th>ID </th>
            <th>Image</th>
            <th>Email</th>
            <th>Password</th>
            <th>Time</th>
        </tr>
        <?php
            while($visitor = $visitors->fetch_assoc()){
                ?>
                <tr>
                    <td><?php echo $visitor['visitor_id'] ?></td>
                    <td>
                        <button class="btn btn-outline-danger" data-bs-visitor_id="<?php echo $visitor['visitor_id']; ?>" data-bs-toggle="modal" data-bs-target="#removeVisitor_Modal"><i class="fa fa-trash"></i></button>
                    </td>
                    <td><?php echo $visitor['visitor_fname']. " ". $visitor['visitor_lname']; ?></td>
                    <td><?php echo $visitor['visitor_id_proof']; ?></td>
                    <td  data-bs-img="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($visitor['visitor_id_proof_img']); ?>" data-bs-toggle="modal" data-bs-target="#id_proof_img_Modal"><p class="text-info" style="cursor:pointer;">Show <i class="fa fa-eye"></i></p></td>                    

                    <td><?php echo $visitor['visitor_email']; ?></td>
                    
                    <td><?php echo $visitor['visitor_passwd']; ?></td>

                    <td><?php echo date("d-M-y H:i", strtotime($visitor['reg_time'])); ?></td>
                </tr>
                <?php
            }
        ?>        
    </table>
    <div class="modal fade" id="removeVisitor_Modal" tabindex="-1" aria-labelledby="removeVisitor_ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="removeVisitor_ModalLabel">Remove Visitor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-info" id="warning"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <button type="submit" name="remove_id" id="removeBtn" class="btn btn-outline-danger">Remove</button>
                </form>
            </div>
            </div>
        </div>
    </div>
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
                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var removeVisitor_Modal = document.getElementById('removeVisitor_Modal')
    removeVisitor_Modal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var id = button.getAttribute('data-bs-visitor_id')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var modalTitle = removeVisitor_Modal.querySelector('.modal-title')
    var warning = document.getElementById("warning");
    warning.innerHTML = "Do you really want to remove "+id+" ?"
    modalTitle.textContent = "Remove "+id
    document.getElementById("removeBtn").value = id
    })


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
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>