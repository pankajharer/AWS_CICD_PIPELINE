<?php
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $email = $_GET['email'];
        require "connection.php";
        
        $query = "select visitor_fname, visitor_id, visitor_email, visitor_passwd, evs from visitors where visitor_id = '$id' and visitor_email = '$email'";
        
        $rows = mysqli_query($con, $query);
        while($row = $rows->fetch_assoc()){
            
            if($row['evs'] == "Active"){
                echo "<script>alert('Hiii ".$row['visitor_fname'].".. Email ID Already Verified')</script>";
            }else{
                echo "<script>alert('Hiii ".$row['visitor_fname'].".. We are verifying your Email..')</script>";
                $update_evs = "update visitors set evs = 'Active' where visitor_id='$id'";
                
                $con->query($update_evs);

                if($con->affected_rows > 0){
                    echo "<script>alert('Email Verified Successfully')</script>";
                    $_SESSION['msg'] = "Email Verified Successfully";
                    
                    $password = $row['visitor_passwd'];
                    $email = $row['visitor_email'];
                    $role = "password";
                    ob_start();
                    include 'send_Login_cred.php';
                    $subject = "National Museum [Login Credentials]";
                    $body = ob_get_clean();
                    include 'sendEmail.php';
                }else{
                    echo "<script>alert('Email Not Verified Try Again')</script>";
                }
            }
        }
        echo "<script>location.href = '/museum'</script>";
    }else{
        header("Location: /museum");
    }
?>