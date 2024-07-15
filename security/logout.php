<?php

session_start();
$_SESSION['security_login'] = null;
echo  "<script>alert('Logged out Successfully..');  location.href = '/museum/security.php'</script>";
?>