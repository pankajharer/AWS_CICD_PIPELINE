<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details | National Museum</title>
</head>
<body>
    <div class="container">
        <div style="background-color:transperent; font-family:sans-serif;padding:20px;text-align: justify; justify-content: center;">
        <h1>Welcome to National Museum</h1><br>
        <p style="font-family: monospace">Where Life and Science meets in a place</p>
            <br><br>
            <p style="text-align: left;font-size: 20px; ">We are very glad to see you here..!! We hope you are fine. <br><br>
            Thank you for showing interest in <b>Ticketless Entry Pass</b>.<br><br>            
            <span style="font-size: 15px; font-family: monospace;"><b>"The rarest specimens might give you the chills."</b></span>
            <h3>Booking Details : </h3>
            <table>
                <tr>
                    <th>Visitor ID</th>
                    <td style="padding: 2px; border-left: 2px solid aquamarine; font-weight: bold;">&nbsp; : <?php echo $visitor_id ; ?></td>
                </tr>    
                <tr>
                    <th>Booking ID</th>
                    <td style="padding: 2px; border-left: 2px solid aquamarine; font-weight: bold;">&nbsp; : <?php echo $booking_id; ?></td>                    
                </tr>
                <tr>
                    <th>Slot ID</th>
                    <td style="padding: 2px; border-left: 2px solid aquamarine; font-weight: bold;">&nbsp; : <?php echo $slot_id; ?></td>
                </tr>
                <tr>
                    <th>Slot No</th>
                    <td style="padding: 2px; border-left: 2px solid aquamarine; font-weight: bold;">&nbsp; : <?php echo $slot_no; ?></td>
                </tr>
                <tr>
                    <th>No of Visitor</th>
                    <td style="padding: 2px; border-left: 2px solid aquamarine; font-weight: bold;">&nbsp; : <?php echo $no_of_members; ?></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td style="padding: 2px; border-left: 2px solid aquamarine; font-weight: bold;">&nbsp; : <?php echo $member_names; ?></td>
                </tr>
                <tr>
                    <th>Fees</th>
                    <td style="padding: 2px; border-left: 2px solid aquamarine; font-weight: bold;">&nbsp; : <?php echo $fees; ?></td>
                </tr>                
                <tr>
                    <th>Visit Date</th>
                    <td style="padding: 2px; border-left: 2px solid aquamarine; font-weight: bold;">&nbsp; : <?php echo $visit_date; ?></td>
                </tr>
                <tr>
                    <th>Order ID</th>
                    <td style="padding: 2px; border-left: 2px solid aquamarine; font-weight: bold;">&nbsp; : <?php echo $razorpay_order_id; ?></td>
                </tr>
                <tr>
                    <th>Payment ID</th>
                    <td style="padding: 2px; border-left: 2px solid aquamarine; font-weight: bold;">&nbsp; : <?php echo $razorpay_payment_id; ?></td>
                </tr>                
                <tr>
                    <th>Book Time</th>
                    <td style="padding: 2px; border-left: 2px solid aquamarine; font-weight: bold;">&nbsp; : <?php echo date("d-M-Y H:i", strtotime($book_time)); ?></td>
                </tr>
            </table>
            <br>
            <img src="http://api.qrserver.com/v1/create-qr-code/?color=000000&amp;bgcolor=FFFFFF&amp;data=http://<?php echo $_SERVER['HTTP_HOST']; ?>/museum/check_booking.php?id=<?php echo $booking_id;?>&amp;qzone=1&amp;margin=0&amp;size=150x150&amp;ecc=L" alt="qr code" />
            </p>
            <div style="text-align: center;">
                <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/museum/check_booking.php?id=<?php echo $booking_id; ?>"><button style="background-color:#2965ff; padding:5%; border-radius: 10px; border: 5px solid #03fcd3; font-size: 25px; cursor:pointer; font-weight:bold;padding:1%;color:white;">Check Booking</button></a>
            </div>
        </div>
    </div>
</body>
</html>