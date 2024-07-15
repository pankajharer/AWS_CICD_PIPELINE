<?php
session_start();
//  Checks the button is clicked and the CSRF token is valid.
if(isset($_POST['register']) && $_POST['csrf_token'] == $_SESSION['csrf_token']){
    require "connection.php";
    
    $id_proof = $_POST['id_proof'];

    //  Check ID Proof
    mysqli_query($con, "select visitor_id from visitors where visitor_id_proof = '$id_proof' limit 1");
    if($con->affected_rows > 0){
        echo "<script>alert('Adhaar ID Already Exist.'); location.href = '/museum/register.php'</script>";
    }else{
        $email = $_POST['email'];
        //  Checks Mobile No or Email ID Exist or Not
        mysqli_query($con, "select visitor_id from visitors where visitor_email = '$email' limit 1");
        if($con->affected_rows > 0){        
            echo "<script>alert('Email Already Exist.');</script>";
        }else{
            // auto-generating Visitor ID
            $visitor_id = rand(10000,90000)."@NM";
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            
            if(!empty($_FILES["id_proof_img"]["name"])) { 
                
                $fileName = basename($_FILES["id_proof_img"]["name"]);
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                
                // Allow certain file formats 
                $allowTypes = array('jpg', 'png', 'PNG', 'jpeg');
                if(in_array($fileType, $allowTypes)){
                    $id_proof_img = $_FILES['id_proof_img']['tmp_name']; 
                    $imgContent = addslashes(file_get_contents($id_proof_img));
                    
                    date_default_timezone_set('Asia/Kolkata');
                    $dt=date("Y-m-d H:i:s");
                    
                    //  Generating Random Password
                    $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                    $pass = array();
                    $combLen = strlen($comb) - 1;
                    for ($i = 0; $i < 8; $i++) {
                        $n = rand(0, $combLen);
                        $pass[] = $comb[$n];
                    }
                    $passwd = implode($pass);

                    //  Inserting Information to Visitors Table
                    $insert_query = "insert into visitors (visitor_id, visitor_id_proof, visitor_id_proof_img, visitor_email, visitor_passwd, visitor_fname, visitor_lname, evs,reg_time) values
                                    ('$visitor_id', '$id_proof', '$imgContent', '$email', '$passwd', '$fname', '$lname', 'Inactive', '$dt')";
                    $insert = mysqli_query($con, $insert_query);
                    if($insert){

                        $role = "evs";
                        ob_start();
                        include 'verifyemailcontent.php';
                        $subject = "National Museum [Email Verification]";
                        $body = ob_get_clean();
                        include 'sendEmail.php';
                        $_SESSION['msg'] = "You are registered sucessfully..! \nEmail Verification sent to Email.";                            

                    }else{
                        echo "<script>alert('Something went wrong, please try again.')</script>";
                    }
                }else{
                    echo "<script>alert('Sorry, only JPG, JPEG, PNG files are allowed to upload.')</script>"; 
                }
            }else{
                echo "<script>alert('Upload ID Proof Image.')</script>"; 
            }
        }
    }
    echo "<script>location.href = '/museum/register.php'</script>";     
}else{
    header("Location: /museum");
}
?>