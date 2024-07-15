<?php

    use PHPMailer\PHPMailer\PHPMailer;   

    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "services.propad@gmail.com";
    $mail->Password = 'lmiqsegofxgsjbnl';
    $mail->Port = 465; //587
    $mail->SMTPSecure = "ssl"; //tls
    
    $headers = 'MIME-Version: 1.0';
    $headers = 'Content-type: text/html; charset=iso-8859-1';
    
    //Email Settings
    $mail->isHTML(true);
    $mail->setFrom($email);
    if($role == "contact_form"){
        $mail->setFrom("dhobaleprasad3@gmail.com");
        $mail->addAddress("dhobaleprasad3@gmail.com");
    }else{
        $mail->addAddress($email);
    }
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->header = $subject;

    if ($mail->send()) {
        if($role == "evs"){
            echo  "<script>alert('Please Verify Your Email From Your Email Inbox')</script>";
        } else if($role == "password"){
            echo "<script>alert('Your Password is sent to your verified Email :)')</script>";
        } else if($role == "contact_form"){
            echo  "<script>alert('Thanks for Contacting $name. \\n We will Contact You Soon.')</script>";
        } else if($role == "booking"){
            echo "<script>alert('Booking Details sent to your registered Email.')</script>";
        }
    } else {
        echo "<script>alert('Something Went Wrong');</script>";
    }
?>