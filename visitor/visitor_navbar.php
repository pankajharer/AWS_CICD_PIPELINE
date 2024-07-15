<?php
session_start();
if(isset($_SESSION['id'])){

    require "../connection.php";

    date_default_timezone_set('Asia/Kolkata');
    $dt=date("Y-m-d H:i:s");

    $id = $_SESSION['id'];    
    $get_profile_query = "select *from visitors where visitor_id = '$id'";

    $row = mysqli_query($con, $get_profile_query)->fetch_assoc();
    $_SESSION['visitor'] = array(
        "visitor_id" => $row['visitor_id'],
        "visitor_id_proof" => $row['visitor_id_proof'],
        "visitor_id_proof_img" => $row['visitor_id_proof_img'],
        "visitor_email" => $row['visitor_email'],
        "visitor_passwd" => $row['visitor_passwd'],
        "visitor_fname" => $row['visitor_fname'],
        "visitor_lname" => $row['visitor_lname'],
        "visitor_evs" => $row['evs'],
        "reg_time" => $row['reg_time']
    );

    $get_fees = "select fees from fees limit 1";
    $fees = mysqli_query($con, $get_fees)->fetch_assoc();
    
    if($con->affected_rows == 0){
        echo "<script>alert('Entry Fees not set yet...'); location.href=  '../login.php'</script>";
    }

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
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>

        <title><?php echo $_SESSION['visitor']['visitor_fname'] ." Dashboard"; ?></title>
    </head>
    <body>
        <nav class="navbar navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><i class="fa fa-user"></i> <?php echo $_SESSION['visitor']['visitor_fname']. " ". $_SESSION['visitor']['visitor_lname']; ?></a>                
                <div class="d-flex">
                    <button class="btn btn-outline-danger" onclick="location.href = 'logout.php'"><b>Logout</b></button>
                </div>
            </div>
        </nav>
    <?php
}else{
    echo "<script>alert('Please login first...'); location.href=  '../login.php'</script>";
}
?>