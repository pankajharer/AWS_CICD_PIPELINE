<?php
session_start();

if(isset($_POST['loginBtn']) && isset($_POST['csrf_admin']) && ($_SESSION['csrf_admin'] == $_POST['csrf_admin'])){
    
    if($_POST['username'] == "nm" && $_POST['password'] == "1234"){
        echo "Continue to Dashboard";
        $_SESSION['admin_login'] = true;
        header("Location: admin");
    }else{
        $_SESSION['msg'] = "Incorrect Username or Password";
        header("Location: admin.php");
    }
}else{
    header("Location: index.php");
}
?>