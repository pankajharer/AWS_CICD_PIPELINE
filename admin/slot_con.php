<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
$dt=date("Y-m-d H:i:s");
require "../connection.php";

// Create a Regular Slots with Expiry Date :)

if(isset($_POST['setRegularSlot'])){
    
    // Get Recent Slot Date
    $get_date_query = "select slot_id, schedule_date, reason from slots where reason like 'regular%' order by schedule_time desc limit 1";
    $slots = mysqli_query($con, $get_date_query);
    $old_slot = '';
    if($con->affected_rows > 0){
        $slot = $slots->fetch_assoc();

        $old_slot = [
            'slot_id' => $slot['slot_id'],
            'schedule_date' => $slot['schedule_date'],
            'reason' => $slot['reason'],
        ];
    }
    
    $slots = $_SESSION['slots'];
    $regular_slots_upto = $_SESSION['regular_slots_upto'];
        
    $slot_id = "slot".rand(1000,9000);
    for($i=1; $i<= $slots; $i++){
        $slot_no = $i;
        $visitor_limit = $_POST['visitor_limit_'.$i];
        $slot_from = $_POST['slot_from_'.$i];
        $slot_to = $_POST['slot_to_'.$i];

        if($i == 1){
            //  For Regular Recent Slot
            if($old_slot != null)
                $schedule_no = "regular,".explode(",", $old_slot['reason'])[1]+1;
            else
                $schedule_no = 'regular,1';

            $regular_slot_query = "insert into slots (slot_id, schedule_date, reason, slot_no, slot_from, slot_to, visitor_limit, schedule_time) values
            ('$slot_id', '$regular_slots_upto', '$schedule_no', '$slot_no', '$slot_from', '$slot_to', '$visitor_limit', '$dt')";
        }else{
            $regular_slot_query = "insert into slots (slot_id, slot_no, slot_from, slot_to, visitor_limit, schedule_time) values
            ('$slot_id', '$slot_no', '$slot_from', '$slot_to', '$visitor_limit', '$dt')";
        }
        mysqli_query($con, $regular_slot_query);
    }
    if($con-> affected_rows > 0){
        echo "<script>alert('Regular Slot Created Successfully..'); location.href = 'slots.php'</script>";        
    }
}


// Create Schedule for Slot.

if(isset($_POST['setScheduleSlot'])){
    

    $slots_limit = $_SESSION['slots'];
    $schedule_slot_date = $_SESSION['schedule_slot_date'];
    $reason = $_SESSION['schedule_reason'];

    
    // Get Recent Slot Date
    $get_date_query = "select slot_id, schedule_date, reason from slots where reason like 'schedule%' order by schedule_time desc limit 1";
    $slots = mysqli_query($con, $get_date_query);
    $old_slot = '';
    if($con->affected_rows > 0){
        $slot = $slots->fetch_assoc();

        $old_slot = [
            'slot_id' => $slot['slot_id'],
            'schedule_date' => $slot['schedule_date'],
            'reason' => $slot['reason'],
        ];
    }
    
    $slot_id = "sSlot".rand(1000,9000);
    for($i=1; $i<= $slots_limit; $i++){
        $slot_no = $i;
        $visitor_limit = $_POST['visitor_limit_'.$i];
        $slot_from = $_POST['slot_from_'.$i];
        $slot_to = $_POST['slot_to_'.$i];

        if($i == 1){
            //  For Scheduled Recent Slot
            if($old_slot != null)
                $schedule_no = "schedule,".explode(",", $old_slot['reason'])[1]+1;
            else
                $schedule_no = 'schedule,1';
            
            $reason = $schedule_no.",".$reason;

            $regular_slot_query = "insert into slots (slot_id, schedule_date, reason, slot_no, slot_from, slot_to, visitor_limit, schedule_time) values
            ('$slot_id', '$schedule_slot_date', '$reason', '$slot_no', '$slot_from', '$slot_to', '$visitor_limit', '$dt')";
        }else{
            $regular_slot_query = "insert into slots (slot_id, slot_no, slot_from, slot_to, visitor_limit, schedule_time) values
            ('$slot_id', '$slot_no', '$slot_from', '$slot_to', '$visitor_limit', '$dt')";
        }
        mysqli_query($con, $regular_slot_query);
    }
    if($con-> affected_rows > 0){
        echo "<script>alert('Slot Scheduled Successfully..'); location.href = 'slots.php'</script>";        
    }
}
?>