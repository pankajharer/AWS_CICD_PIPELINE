<?php
    
    // Enter your host name, database username, password, and database name.
    // If you have not set database password on localhost then set empty.
    $con = mysqli_connect("localhost","root","","museum");
    
    // Check connection
    if (mysqli_connect_errno()){
        echo "Failed to Connect to MySQL: " . mysqli_connect_error();
    }
    // else{echo "Connected";}
?>
