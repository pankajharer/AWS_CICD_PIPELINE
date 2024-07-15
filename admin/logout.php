<?php

session_start();
$_SESSION['admin_login'] = null;
echo  "<script>alert('Logged out Successfully..');  location.href = '/museum/admin.php'</script>";
?>