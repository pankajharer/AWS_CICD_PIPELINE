<?php
session_start();
if(isset($_SESSION['admin_login'])){
    require "../connection.php";
    
    date_default_timezone_set('Asia/Kolkata');
    $dt=date("Y-m-d H:i:s");
    ?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../img/logo.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
            
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet" />

        <script src="https://kit.fontawesome.com/18b4046e5e.js" crossorigin="anonymous"></script>

        <title>Admin | National Museum</title>
    </head>
    <body>
        <nav class="navbar navbar-info bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><i class="fa fa-user"></i> Dashboard</a>
                <div class="d-flex">
                    <button class="btn btn-outline-danger" onclick="location.href = 'logout.php'">Logout</button>                    
                </div>
            </div>
        </nav>
    <?php
}else{
    echo "<script>alert('Please login first...'); location.href=  '../admin.php'</script>";
}
?>