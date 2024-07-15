<?php
session_start();
if($_POST['forgot'] && $_SESSION['csrf_fp'] == $_POST['csrf_fp']){
    
    $email = $_POST['email'];
    
    require "connection.php";
    
    $check_evs_query = "select visitor_id, visitor_email, visitor_passwd, evs from visitors where visitor_email = '$email'";
    $row = mysqli_query($con, $check_evs_query)->fetch_assoc();
    if($con->affected_rows > 0){
        if($row['evs'] != "Active"){
            $_SESSION['msg'] = "Email ID not verified..!";
            
            $_SESSION['resend'] = array(
                'visitor_email' => $email,
                'visitor_id' => $row['visitor_id']
            );
            header("Location: /museum/login.php");
        }else{
            $password = $row['visitor_passwd'];
            $email = $row['visitor_email'];
            $role = "password";
            ob_start();
            include 'send_Login_cred.php';
            $subject = "National Museum [Login Credentials]";
            $body = ob_get_clean();
            include 'sendEmail.php';
            $_SESSION['msg'] = "Login Credentials sent to your registered Email.";
            header("Location: /museum/login.php");
        }
    }else{
        $_SESSION['msg'] = "Email ID Not Exist..!.";
        header("Location: /museum/login.php");
    }
}else{
    header("Location: /museum/forgot-password.php");
}

?>