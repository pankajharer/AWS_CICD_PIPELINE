<?php
session_start();
if(isset($_SESSION['security_login'])){

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
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>

        <title><?php echo $_SESSION['security']['sec_name'] ." Dashboard"; ?></title>
    </head>
    <body>
        <nav class="navbar navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php" data-bs-toggle="modal" data-bs-target="#showProfileModal"><i class="fa fa-user"></i> <?php echo $_SESSION['security']['sec_name']; ?></a>
                <div class="d-flex">
                    <button class="btn btn-outline-danger" onclick="location.href = 'logout.php'"><b>Logout</b></button>
                </div>
            </div>
        </nav>
        <div class="container mt-5 p-5 shadow">
            <h2>Follow Given Steps While Visitor Entering and Exists.</h2>
            <hr>
            <ol>
                <li><p class="p-1 text-danger fw-bold">Scan QR code of visitor's booking by any scanner and open link in browser.</p></li>    
                <li><p class="p-1">Verify visitors with the uploaded ID proof.</p></li>
                <li><p class="p-1">Check the <b>slot ID</b> with <b>slot number</b>.</p></li>
                <li><p class="p-1">Count the number of members with the visitor.</p></li>
                <li><p class="p-1">Check visit date is same as current date.</p></li>
                <li><p class="p-1 fw-bold">Verify Checkin and Checkout Status is NA.</p></li>
                <li><p class="p-1">While entering click the checkin button and Say <b>"Welcome"</b> to visitors.</p></li>
                <li><p class="p-1">While exiting click the checkout button and Say <b>"Thanks, visit again..!"</b> to vistors.</p></li>
                <li><p class="p-1">If any emergency, urgently contact to the Admin.</p></li>
            </ol>
        </div>

        <div class="modal fade" id="showProfileModal" tabindex="-1" aria-labelledby="showProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showProfileModalLabel"><?php echo $_SESSION['security']['sec_name']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <tr>
                                <th>Security ID</th>
                                <td><?php echo $_SESSION['security']['sec_id']; ?></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td><?php echo $_SESSION['security']['sec_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Email ID</th>
                                <td><?php echo $_SESSION['security']['sec_email']; ?></td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td><?php echo $_SESSION['security']['sec_passwd']; ?></td>
                            </tr>
                            <tr>
                                <th>Reg Time</th>
                                <td><?php echo (date("d-M-Y H:i", strtotime($_SESSION['security']['reg_time']))) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
    <?php
}else{
    echo "<script>alert('Please login first...'); location.href=  '../security.php'</script>";
}
?>