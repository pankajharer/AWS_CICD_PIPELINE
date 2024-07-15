<?php

if(isset($_GET['id']) && isset($_GET['p'])){
    $id = $_GET['id'];
    $passwd = $_GET['p'];

    require "connection.php";
        
    $query = "select visitor_fname, visitor_id, visitor_email, visitor_passwd, mvs from visitors where visitor_id = '$id' and visitor_passwd = '$passwd'";
    
    $rows = mysqli_query($con, $query);
    while($row = $rows->fetch_assoc()){
        
        if($row['mvs'] == "Active"){
            echo "<script>alert('Hiii ".$row['visitor_fname'].".. Phone Number Already Verified')</script>";
        }else{
            echo "<script>alert('Hiii ".$row['visitor_fname'].".. We are verifying your Phone Number..')</script>";
            $update_evs = "update visitors set mvs = 'Active' where visitor_id='$id'";
            
            $con->query($update_evs);

            if($con->affected_rows > 0){
                echo "<script>alert('Phone Number Verified Successfully')</script>";
                $_SESSION['msg'] = "Phone Number Verified Successfully";
            }else{
                echo "<script>alert('Phone Number not Verified Try Again')</script>";
            }
        }
    }
    session_start();
    $_SESSION['visitor'] = null;
    echo "<script>location.href = 'login.php'</script>";
}else{
    header("Location: /museum");
}


?>