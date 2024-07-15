<?php

session_start();
$_SESSION['id'] = null;
echo  "<script>alert('Logged out Successfully..');  location.href = '/museum/login.php'</script>";
?>