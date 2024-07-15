<?php

require "navbar.php";
require "connection.php";
if(isset($_GET['slot_id'])){
    
    date_default_timezone_set('Asia/Kolkata');
    $today=date("Y-m-d H:i:s");

    $slot_id = $_GET['slot_id'];
    $get_slot_details_query = "select *from slots where slot_id = '$slot_id'";
    $slots = mysqli_query($con, $get_slot_details_query)->fetch_assoc();

    if($con->affected_rows > 0){
        ?>
        <div class="container mt-5 table-responsive">
            <p class="text-info"><b>
                Slot ID : <?php echo $slots['slot_id']; ?> <br>
                <?php
                if(explode(",",$slots['reason'])[0] != "schedule"){
                    $chk_book_avail = "select no_of_members as members, slot_id, slot_no from bookings where visiting_date = '$today'";
                ?>
                    Schedule : <?php echo date("d-M-Y", strtotime($slots['schedule_time']))." to ".date("d-M-Y", strtotime($slots['schedule_date'])); ?>                    
                <?php
                }else{
                    $schedule_date = $slots['schedule_date'];
                    $chk_book_avail = "select no_of_members as members, slot_id, slot_no from bookings where visiting_date = '$schedule_date'";
                ?>
                    Schedule : <?php echo date("d-M-Y", strtotime($slots['schedule_date'])); ?> <br>
                    Reason : <?php echo $slots['reason']; ?>
                <?php
                }
                ?>
                </b>
            </p>
            <table class="table table-hover">
                <tr class="bg-secondary">
                    <th>Slot No</th>
                    <th>Slot From</th>
                    <th>Slot To</th>
                    <th>Availability</th>
                    <th>Visitor Limit</th>
                </tr>
                <?php
                
                $slots = mysqli_query($con, $get_slot_details_query);
                while($slot = $slots->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $slot['slot_no']; ?></td>
                        <td><?php echo $slot['slot_from']; ?></td>
                        <td><?php echo $slot['slot_to']; ?></td>
                        <td>
                            <?php
                                $remaining_availability = 0;
                                $slot_visitor_limit = $slot['visitor_limit'];
                                
                                $schedules = mysqli_query($con, $chk_book_avail);
                                
                                if($con->affected_rows > 0){
                                    $visitors = 0;
                                    while($schedule = $schedules->fetch_assoc()){
                                        if($schedule['slot_no'] == $slot['slot_no'])
                                            $visitors += $schedule['members'];
                                    }
                                    $remaining_availability = $slot_visitor_limit - $visitors;
                                }else{
                                    $remaining_availability = $slot_visitor_limit;
                                }                                

                                echo $remaining_availability; 
                            ?>
                        </td>
                        <td><?php echo $slot['visitor_limit']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <?php
    }else{
        echo "<script>alert('Invalid Slot ID..'); location.href = 'index.php'</script>";
    }
}else{
    header("Location: index.php");
}