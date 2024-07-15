<?php

require('config.php');
session_start();
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

if(!$_SESSION['id']){
    header("Location: ../");
}else{    
    require('razorpay-php/Razorpay.php');
    require('../../connection.php');
    
    $success = true;

    $error = "Payment Failed";

    if (empty($_POST['razorpay_payment_id']) === false){
        $api = new Api($keyId, $keySecret);

        try{
            // Please note that the razorpay order ID must
            // come from a trusted source (session here, but
            // could be database or something else)
            $attributes = array(
                'razorpay_order_id' => $_SESSION['razorpay_order_id'],
                'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                'razorpay_signature' => $_POST['razorpay_signature']
            );

            $api->utility->verifyPaymentSignature($attributes);
        }
        catch(SignatureVerificationError $e){
            $success = false;
            $error = 'Razorpay Error : ' . $e->getMessage();
        }
    }

    if ($success === true){
        

        $visitor_id = $_SESSION['visitor']['visitor_id'];
        $slot_id = $_SESSION['slot_id'];
        $slot_no = $_SESSION['slot_no'];
        $booking_id = rand(100000,900000)."NM";
        $fees = $_SESSION['fees'];
        $visit_date = $_SESSION['visit_date'];
        $no_of_members = $_SESSION['no_of_members'];
        $member_names = $_SESSION['member_names'];
        $member_ages = $_SESSION['member_ages'];
        $member_genders = $_SESSION['member_genders'];

        $member_details = "";
        $member_details = $member_details . $member_names."|". $member_ages ."|".  $member_genders;

        $razorpay_order_id = $_SESSION['razorpay_order_id'];
        $razorpay_payment_id = $_POST['razorpay_payment_id'];
        
        date_default_timezone_set('Asia/Kolkata');
        $book_time=date("Y-m-d H:i:s");

        // echo $visitor_id, $booking_id, $no_of_members, $member_names, $fees,  $visit_date, $slot_id, $slot_no;
        
        $booking_query = "insert into bookings (visitor_id, booking_id, no_of_members, member_details, booking_price, visiting_date, slot_id, slot_no, checkin, checkin_sec, checkout, checkout_sec, order_id, razorpay_payment_id, paid_status, book_time) values
                                            ('$visitor_id', '$booking_id', $no_of_members, '$member_details', '$fees', '$visit_date', '$slot_id', $slot_no, '-', '-','-', '-', '$razorpay_order_id', '$razorpay_payment_id', 'success', '$book_time')";
        mysqli_query($con, $booking_query);

        // echo $booking_query;
        
        if($con->affected_rows > 0){
            $email = $_SESSION['visitor']['visitor_email'];
            echo "<script>alert('Payment Successfull..!')</script>";
            $role = "booking";
            ob_start();
            include 'booking_email.php';
            $subject = "National Museum [Booking Details]";
            $body = ob_get_clean();
            include '../../sendEmail.php';
        }
        echo "<script>alert('Thanks From National Museum..!')</script>";
    }
    else{
        echo "<script>alert('Payment Failed..!')</script>";
    }
    echo "<script>location.href = '../' </script>";
}
?>