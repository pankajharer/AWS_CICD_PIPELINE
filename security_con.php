<?php

session_start();

if(isset($_POST['loginBtn']) && isset($_POST['csrf_security']) && ($_SESSION['csrf_security'] == $_POST['csrf_security'])){
    
    require "connection.php";
    $sec_id = $_POST['sec_id'];
    $sec_passwd = $_POST['sec_passwd'];

    $fetch_security_query = "select * from security where sec_email = '$sec_id' and sec_passwd = '$sec_passwd'";
    $security = mysqli_query($con, $fetch_security_query)->fetch_assoc();
    
    if($con->affected_rows > 0){
            echo "Continue to Dashboard ";
            $_SESSION['security_login'] = true;
            
            $_SESSION['security'] = array(
                "sec_id" => $security['sec_id'],
                "sec_passwd" => $security['sec_passwd'],
                "sec_name" => $security['sec_name'],
                "sec_email" => $security['sec_email'],
                "sec_mobile" => $security['sec_mobile'],
                "reg_time" => $security['reg_time']
            );
            header("Location: security");        
    }else{
        $_SESSION['msg'] = "Query, Incorrect Username or Password";
        header("Location: security.php");
    }
}else{
    header("Location: index.php");
}
?>