<?php
require "admin_navbar.php";

require "../connection.php";

date_default_timezone_set('Asia/Kolkata');
$dt=date("Y-m-d H:i:s");


if(isset($_POST['register'])){
            
    $sec_email = $_POST['sec_email'];

    $check_sec_email = "select sec_email from security where sec_email ='$sec_email'";
    $email = mysqli_query($con, $check_sec_email)->fetch_assoc();
    if($con->affected_rows > 0){
        echo "<script>alert('Security Email Already Exist..!')</script>";
    }else{
    
        $sec_id = $_POST['sec_id'];
        $sec_name =  $_POST['sec_name'];            
        $sec_passwd = $_POST['sec_passwd'];
        $sec_mobile = $_POST['sec_mobile'];
        
        $reg_sec_query = "insert into security values ('$sec_id', '$sec_name', '$sec_email', '$sec_passwd', '$sec_mobile', '$dt')";

        mysqli_query($con, $reg_sec_query);
        if($con->affected_rows > 0){

            $password = $sec_passwd;
            $email = $sec_email;
            $role = "password";
            ob_start();
            include '../send_Login_cred.php';
            $subject = "National Museum [Login Credentials For Security ID : '$sec_id']";
            $body = ob_get_clean();
            include '../sendEmail.php';
            echo "<script>alert('Security Registered Successfully..!')</script>";
        }
    }
}

if(isset($_POST['update'])){
    
    $u_id = $_POST['sec_id'];
    $u_email = $_POST['sec_email'];
    $u_name = $_POST['sec_name'];
    $u_passwd = $_POST['sec_passwd'];
    $u_mob = $_POST['sec_mobile'];

    $update_sec_query = "update security set sec_name = '$u_name', sec_passwd = '$u_passwd', sec_mobile = '$u_mob' where sec_id = '$u_id'";
    mysqli_query($con, $update_sec_query);
    if($con->affected_rows > 0){

        $password = $u_passwd;
        $email = $u_email;
        $role = "password";
 
        ob_start();
        include '../send_Login_cred.php';
        $subject = "National Museum [Updated - Login Credentials For Security ID : '$sec_id']";
        $body = ob_get_clean();
        include '../sendEmail.php';
        echo "<script>alert('Security Updated Successfully..!')</script>";
    }else{
        echo "<script>alert('Something Went Wrong Try Again..!')</script>";
    }
}

if(isset($_POST['del_button'])){
    $sec_id = $_POST['del_sec_id'];
    $del_query = "delete from security where sec_id = '$sec_id'";
    mysqli_query($con, $del_query);
    if($con->affected_rows > 0){
        echo "<script>alert('Security Deleted Successfully')</script>";
    }else{
        echo "<script>alert('Something Went Wrong..!')</script>";
    }
}


?>

    <div class="container p-4 mt-4 mb-5 shadow border rounded w-75">
        <?php
        if(isset($_GET['sec_id'])){
            $sec_id = $_GET['sec_id'];
            $get_sec_details = "select *from security where sec_id = '$sec_id'";
            $sec = mysqli_query($con, $get_sec_details)->fetch_assoc();
            ?>
                <h2 class="text-info m-4 text-center">Update Security</h2>
            <?php
        }else{
            ?>
                <h2 class="text-info m-4 text-center">Register Security Guard</h2>
            <?php
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php echo isset($_GET['sec_id']) ?  ("Security ID : $sec_id ") : ''; ?>
            <div class="mt-5">
                <label for="sec_name" class="mb-2"><b>Name</b></label>
                <input type="text" placeholder="John Martin" value="<?php echo isset($_GET['sec_id']) ?  $sec['sec_name'] : ''; ?>" name="sec_name" id="sec_name" class="form-control" required>
            </div>
            <div class="mt-5">
                <label for="sec_email" class="mb-2"><b>Email ID</b> <p class="text-warning">you can't update email.</p></label>
                <input type="hidden" name="sec_id" value="<?php echo isset($_GET['sec_id']) ?  $sec['sec_id'] : rand(0000, 100000); ?>">
                <input type="email" placeholder="john@gmail.com" value="<?php echo isset($_GET['sec_id']) ?  $sec['sec_email'] : ''; ?>" name="sec_email" id="sec_email" class="form-control" <?php echo isset($_GET['sec_id']) ?  'readonly' : ''; ?> >
            </div>
            <div class="mt-4">
                <label for="passwd" class="mb-2"><b>Password</b></label>
                <input type="password" placeholder="********" value="<?php echo isset($_GET['sec_id']) ?  $sec['sec_passwd'] : ''; ?>" name="sec_passwd" id="sec_passwd" class="form-control" required>
            </div>
            <div class="mt-5">
                <label for="sec_mobile" class="mb-2"><b>Mobile</b></label>
                <input type="number" placeholder="+91 9078565623" value="<?php echo isset($_GET['sec_id']) ?  $sec['sec_mobile'] : ''; ?>" name="sec_mobile" id="sec_mobile" class="form-control" required>
            </div>
            <div class="text-center pt-4">
                <?php echo isset($_GET['sec_id']) ? '<button  class="btn btn-success" name="update" value="true"><b>Update </b><i class="fa fa-arrow-right"></i></button>' : '<button  class="btn btn-primary" name="register" value="true"><b>Register </b><i class="fa fa-arrow-right"></i></button>'; ?>
            </div>
        </form>
        <hr>

        <h2>Security Details</h2>
        <p class="text-warning">If you want to update the Email Address, then you have to delete the security and re-register with new details.
        <div class="container table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Action</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Mobile</th>
                    <th>Reg Time</th>
                </tr>

                <?php
                    $get_sec_query = "select *from security";
                    $securities = mysqli_query($con, $get_sec_query);
                    if($con->affected_rows > 0){
                        while($security = $securities->fetch_assoc()){
                            ?>
                            <tr>
                                <td><?php echo $security['sec_id']; ?></td>
                                <td>
                                    <a href="?sec_id=<?php echo $security['sec_id']; ?>"><i class="text-success fa fa-edit"></i></a>
                                    <i class="text-danger fa fa-trash" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-sec_id="<?php echo $security['sec_id']; ?>"></i>                                    
                                </td>
                                <td><?php echo $security['sec_name']; ?></td>
                                <td><?php echo $security['sec_email']; ?></td>
                                <td><?php echo $security['sec_passwd']; ?></td>
                                <td><?php echo $security['sec_mobile']; ?></td>
                                <td><?php echo $security['reg_time']; ?></td>
                            </tr>
                            <?php
                        }
                    }else{
                        echo "<p>No Security Registered Yet..!</p>";
                    }
                ?>                
            </table>
        </div>
    </div>
    
  
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="test-danger">Are you sure to delete the Security ?</p>                
                
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type="hidden" name="del_sec_id" class="form-control" id="sec_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" name="del_button" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var deleteModal = document.getElementById('deleteModal')
        deleteModal.addEventListener('show.bs.modal', function (event) {
        
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var recipient = button.getAttribute('data-bs-sec_id')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var modalTitle = deleteModal.querySelector('.modal-title')
        var modalBodyInput = deleteModal.querySelector('.modal-body input')

        modalTitle.textContent = 'Security ID : ' + recipient
        modalBodyInput.value = recipient
        })
    </script>
</body>
</html>