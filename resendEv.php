<?php

if(isset($_POST['resend']) && isset($_POST['email']) && isset($_POST['id'])){
    $visitor_id = $_POST['id'];
    $email = $_POST['email'];
    $role = "evs";
    ob_start();
    include 'verifyemailcontent.php';
    $subject = "National Museum [Email Verification]";
    $body = ob_get_clean();
    include 'sendEmail.php';
    $_SESSION['msg'] = "Email Verification sent to Email.";
    echo  "<script>alert('Email Verification sent to Email.')</script>";    
    header("Location: /museum/login.php");
}else{
    header("Location: /museum");
}

?>