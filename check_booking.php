<?php

session_start();
require "connection.php";

date_default_timezone_set('Asia/Kolkata');
$dt=date("Y-m-d H:i:s");

if(isset($_POST['checkin'])){
    $id = $_POST['checkin'];
    $sec_id = $_POST['sec_id'];
    $checkin_query = "update bookings set checkin = '$dt', checkin_sec = '$sec_id' where booking_id = '$id'";
    mysqli_query($con, $checkin_query);
    if($con->affected_rows > 0){
        echo "<script>alert('Visitor Checkin Successfully')</script>";
    }else{
        echo "<script>alert('Try again..!')</script>";
    }
}

if(isset($_POST['checkout'])){
    $id = $_POST['checkout'];
    $sec_id = $_POST['sec_id'];
    $checkin_query = "update bookings set checkout = '$dt', checkout_sec = '$sec_id' where booking_id = '$id'";
    mysqli_query($con, $checkin_query);
    if($con->affected_rows > 0){
        echo "<script>alert('Visitor Checkout Successfully')</script>";
    }else{
        echo "<script>alert('Try again..!')</script>";
    }
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $get_booking_query = "select * from bookings where booking_id = '$id'";
    $booking = mysqli_query($con, $get_booking_query)->fetch_assoc();
    if($con->affected_rows > 0){
        require "navbar.php";        
        ?>
        <div class="container mt-4 p-5 shadow">
            <h2>Check Booking Details</h2>
            <hr>
            <div class="table-responsive pt-4">
                <div class="">
                    <table class="table table-hover">
                        <tr>
                            <th>Visitor ID</th>
                            <td><?php echo $booking['visitor_id']; ?></td>
                        </tr>
                        <tr>
                            <th>ID Proof</th>
                            <?php
                            $visitor_id = $booking['visitor_id'];
                            $get_id_proof_query = "select visitor_id_proof from visitors where visitor_id = '$visitor_id'";
                            $id_proof = mysqli_query($con, $get_id_proof_query)->fetch_assoc();
                            ?>
                            <td><?php echo $id_proof['visitor_id_proof']; ?></td>
                        </tr>
                        <tr>
                            <th>Booking ID</th>
                            <td><?php echo $booking['booking_id']; ?></td>
                        </tr>
                        <tr>
                            <th>Slot ID</th>
                            <td><a target="___blank" href="check_slot.php?slot_id=<?php echo $booking['slot_id']; ?>"><?php echo $booking['slot_id']; ?></a></td>
                        </tr>
                        <tr>
                            <th>Slot No</th>
                            <td><?php echo $booking['slot_no']; ?></td>
                        </tr>
                        <tr>
                            <th>No Of Visitor</th>
                            <td><?php echo $booking['no_of_members']; ?></td>
                        </tr>                        
                        <tr class="text-center bg-info p-3">
                            <th colspan="3"><u>Member Details Are As Follows</u></th>
                        </tr>
                        <tr class="bg-primary">
                            <th>Age</th>
                            <th>Name</th>
                            <th>Gender</th>
                        </tr>
                        <?php
                        $member_names = explode("|", $booking['member_details'])[0];
                        $member_ages = explode("|", $booking['member_details'])[1];
                        $member_genders = explode("|", $booking['member_details'])[2];
                        
                        for($i=0;$i<$booking['no_of_members']; $i++){
                            $member_name = explode(",", $member_names)[$i];
                            $member_age = explode(",", $member_ages)[$i];
                            $member_gender = explode(",", $member_genders)[$i];
                            ?>
                            <tr>
                                <td><?php echo $member_age; ?></td>    
                                <td><?php echo $member_name; ?></td>
                                <td><?php echo $member_gender; ?></td>
                            </tr>
                            <?php
                            }
                        ?>
                        
                        <tr>
                            <th>Fees</th>
                            <td><?php echo $booking['booking_price']; ?> ₹</td>
                        </tr>
                        <tr>
                            <th>Total Fees</th>
                            <td><b><?php echo $booking['booking_price'] * $booking['no_of_members']; ?> ₹</b></td>
                        </tr>
                        <tr>
                            <th>Visit Date</th>
                            <td><?php echo $booking['visiting_date']; ?></td>
                        </tr>
                        <tr>
                            <th>Check in</th>
                            <td>
                                <?php                                
                                if($booking['checkin'] != "-"){                                
                                    echo date("d-M-Y H:i", strtotime($booking['checkin']));
                                }else{
                                    if(isset($_SESSION['security_login'])){
                                        ?>
                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                            <input type="hidden" name='sec_id' value="<?php echo $_SESSION['security']['sec_id']; ?>">
                                            <button name="checkin" type="submit" value="<?php echo $booking['booking_id']; ?>" class="btn btn-outline-primary"><i class="fa fa-check"></i></button>
                                        </form>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <p><b>NA</b></p>
                                        <?php
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <b>Security ID :</b> <?php echo $booking['checkin_sec']; ?>
                            </td>
                        </tr>
                            </td>                           
                            <tr>
                            <th>Check out</th>
                            <td>
                                <?php
                                if($booking['checkout'] != "-"){                                
                                    echo date("d-M-Y H:i", strtotime($booking['checkin']));
                                }else{
                                    if(isset($_SESSION['security_login'])){
                                        ?>
                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                            <input type="hidden" name='sec_id' value="<?php echo $_SESSION['security']['sec_id']; ?>">
                                            <button name="checkout" type="submit" value="<?php echo $booking['booking_id']; ?>" class="btn btn-outline-primary"><i class="fa fa-check"></i></button>
                                        </form>
                                        <?php
                                    }else{
                                        ?>
                                        <p><b>NA</b></p>
                                        <?php
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <b>Security ID :</b> <?php echo $booking['checkout_sec']; ?>
                            </td>
                        </tr>                        
                        <tr>
                            <th>Order ID</th>
                            <td><?php echo $booking['order_id']; ?></td>
                        </tr>
                        <tr>
                            <th>Payment ID</th>
                            <td><?php echo $booking['razorpay_payment_id']; ?></td>
                        </tr>
                        <tr>
                            <th>Book Time</th>
                            <td><?php echo date("d-M-Y H:i", strtotime($booking['book_time'])); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }else{
        echo "<script>alert('Invalid Booking ID..!')</script>";
        echo "<script>location.href = '/museum'</script>";
    }    
}else{
    echo "<script>location.href = '/museum'</script>";
}
?>