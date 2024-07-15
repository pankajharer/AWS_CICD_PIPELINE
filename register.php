<?php
session_start();
//  CSRF Token
$csrf_token = rand(10000,90000);
$_SESSION['csrf_token'] = $csrf_token;
?>

<?php include "navbar.php"; ?>
    <div class="container p-4 mt-4 mb-5 shadow border rounded">
        <h2 class="text-primary text-center">Register here..!</h2>
        <?php  if(isset($_SESSION['msg'])){  ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>
                <?php echo $_SESSION['msg'];
                    $_SESSION['msg'] = null; 
                ?>
                </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }?>      
        <form onsubmit="return validate();" id="reg_form" method="POST" class="form p-4" enctype="multipart/form-data">            
            <div id="part-2">
                <div class="mb-3 mt-2">
                    <label for="aadhaar_no" id="aadhaar_no_label"><b>Enter Adhar Card Number</b></label>
                    <input type="text" placeholder="eg. 9876    6775    6546" maxlength="20" onchange="aadhaar_validation()" name="id_proof" id="aadhaar_no" class="form-control" required>
                </div>                
                <hr>
                <div class="mb-3">
                    <label for="image"><b>Upload Adhar Card</b> <i class="text-warning"> (Only jpg, jpeg and png)</i></label>
                    <input type="file" name="id_proof_img" onchange="Filevalidation()" id="image" class="form-control" required>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="email"><b>Enter Email ID</b> <i class="text-warning">(We'll send verification email)</i></label>
                    <input type="email" placeholder="eg. john@gmail.com" name="email" id="email" class="form-control" required>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="fname"><b>Enter First Name</b></label>
                    <input type="text" placeholder="eg. Pankaj" name="fname" id="fname" class="form-control" required>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="lname"><b>Enter Last Name</b></label>
                    <input type="text" placeholder="eg. Saxena" name="lname" id="lname" class="form-control" required>
                </div>
                <hr>
                <input type="hidden" name="csrf_token" value = "<?php echo $csrf_token; ?>">
                <div class="text-center p-5">
                    <button class="btn btn-primary" name="register" value="true"><b>Register </b><i class="fa fa-arrow-right"></i></button>
                </div>
            </div>
        </form>
<!--  -->
       
    </div>
    <script>
     

        var goodColor = "#0C6";
        var badColor = "#fc0303";

        
        //  Validates if  proof image is less than 4 mb
        Filevalidation = () => {
            const fi = document.getElementById('image');
            // Check if any file is selected.
            if (fi.files.length > 0) {
                for (var i = 0; i <= fi.files.length - 1; i++) {
    
                    const fsize = fi.files.item(i).size;
                    const file = Math.round((fsize / 1024));
                    // The size of the file.
                    if (file >= 4096) {
                        alert("File too Big, please select a file less than 4mb");
                        fi.style.color = badColor;
                        return false;
                    } else {
                        // document.getElementById('size').innerHTML = "<b>"+ file + "</b> KB";
                        alert("File Uploded Successfully")
                        fi.style.color = goodColor;
                        return true;
                    }
                }
            }
        }


        //  Give Space after 4 digit of aadhaar card no.
        var aadhaar_input = document.getElementById("aadhaar_no");
        aadhaar_input.onkeydown = function () {
            
            if (aadhaar_input.value.length > 0 && aadhaar_input.value.length < 20) {

                if (aadhaar_input.value.length % 4 == 0) {
                    aadhaar_input.value += "    ";
                }
            }
        }


        //  Validates Aadhaar number
        function aadhaar_validation(){
            var regexp=/^[2-9]{1}[0-9]{3}\s\s\s\s{1}[0-9]{4}\s\s\s\s{1}[0-9]{4}$/;
            
            var x = document.getElementById("aadhaar_no");
            
            if(regexp.test(x.value)){
                    x.style.color = goodColor;
                    return true;
            }
            else{
                alert("Invalid Aadhar Number");
                x.style.color = badColor;
                return false;
            }
        }
        
        //  Form Validations
        function validate(){
            
            var email = document.getElementById("email");
            var fname = document.getElementById("fname");
            var lname = document.getElementById("lname");

            var reg_form = document.getElementById("reg_form");
            var mailformat = /^w+([.-]?w+)*@w+([.-]?w+)*(.w{2,3})+$/;

            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)){                                
                
                if(/^[A-Za-z]+$/.test(fname.value) && /^[A-Za-z]+$/.test(lname.value)){
                    
                    if(aadhaar_validation()){
                        reg_form.action = "reg_controller.php";
                        reg_form.submit();
                        return true;
                    }
                }else{
                    alert("Enter only alphabets while entering your name.")
                    return false;
                }
            }else{
                alert("Invalid Email ID")
                email.style.color = badColor;
                return false;
            }
            return false;
        }
   </script>
</body>
</html>