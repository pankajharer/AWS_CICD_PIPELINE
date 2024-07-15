<?php
session_start();
if($_POST['login'] && $_SESSION['csrf_login'] == $_POST['csrf_login']){
    
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];

    require "connection.php";
    
    $check_evs_query = "select * from visitors where visitor_email = '$email' and visitor_passwd = '$passwd'";
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
            $_SESSION['id'] = $row['visitor_id'];
            header("Location: visitor");
        }
    }else{
        $_SESSION['msg'] = "Incorrect Username Or Password..!";
        header("Location: /museum/login.php");
    }
}else{
    header("Location: /museum");
}
?>