<?php
include "admin_navbar.php";

// Schedule Slots
if(isset($_POST['setScheduleSlot'])){
    $schedule_date = $_POST['schedule_date'];
    $chk_slot_date_repeated_query = "select *from slots where schedule_date = '$schedule_date'";
    mysqli_query($con, $chk_slot_date_repeated_query);
    if($con->affected_rows > 0){
        echo "<script>alert('Slots are already scheduled for this date.');</script>";
    }else{
        $reason = $_POST['reason'];
        $slots = $_POST['no_of_slots'];
        $visitors = $_POST['no_of_visitors'];
        $slot_id = "slot".rand(10000,90000);
        $schedule_slots_query = "insert into slots (slot_id, schedule_date, reason, no_of_slots, no_of_visitors, schedule_time)
                                values('$slot_id', '$schedule_date', '$reason', '$slots', '$visitors', '$dt')";
        mysqli_query($con, $schedule_slots_query);
        if($con->affected_rows > 0){
            echo "<script>alert('Slots Scheduled successfully..!')</script>";
        }else{
            echo "<script>alert('Something Went Wrong');</script>";
        }
    }
}
?>
<div class="container mt-5 mb-4 p-4 shadow border-primary">
    <h3 class="text-primary"><b>Manage Slots With Visitors Limit and Time</b></h3>
    <?php
        if(isset($_GET['slot_id'])){
            $slot_id = $_GET['slot_id'];
            $get_slot_details_query = "select *from slots where slot_id = '$slot_id'";
            $slots = mysqli_query($con, $get_slot_details_query)->fetch_assoc();
            if($con->affected_rows > 0){
                ?>
                <div class="table-responsive">
                    <button onclick="location.href ='slots.php'" class="btn btn-outline-primary"><i class="fa fa-arrow-left"></i></button>
                    <p class="text-info"><b>
                        Slot ID : <?php echo $slots['slot_id']; ?> <br>
                        <?php
                        if(explode(",",$slots['reason'])[0] != "schedule"){ 
                        ?>
                            Schedule : <?php echo date("d-M-Y", strtotime($slots['schedule_time']))." to ".date("d-M-Y", strtotime($slots['schedule_date'])); ?>
                        <?php
                        }else{
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
                            <th>Visitor</th>
                        </tr>
                        <?php
                        $slots = mysqli_query($con, $get_slot_details_query);
                        while($slot = $slots->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $slot['slot_no']; ?></td>
                                <td><?php echo $slot['slot_from']; ?></td>
                                <td><?php echo $slot['slot_to']; ?></td>
                                <td><?php echo $slot['visitor_limit']; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <?php
            }
        }
    ?>
    <p class="text-warning">Once Slot is Created or Scheduled, You can't Remove and Update it.</p>
    <div class="inline-group">
        <a href="#regular_slots"><button class="btn btn-outline-info">Regular Slots</button></a>
        <a href="#schedule_slots"><button class="btn btn-outline-primary">Schedule Slots</button></a>
        <a href="#display_slots"><button class="btn btn-outline-success">List Slots</button></a>
    </div>
    <h4 class="text-info p-4" id="regular_slots">Set regular slots with visitors limit per slot</h4>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form" id="get_slot_form">
        <div class="form-floating mb-4">
            <p id="regular_slots_upto_label">Regular Slots Upto</p>    
            <input type="date" name="regular_slots_upto" id="regular_slots_upto" class="form-control" required>
        </div>
        <label for="slot_limit">How much slots do you want ?</label>
        <select class="form-select" name="no_of_slots" aria-label="regular select example">
            <option value="1">01</option>
            <option selected value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
        </select>
        <button name="setSlotDetails" class="mt-5 btn btn-outline-primary" type="submit">Set Slots</button>
    </form>
    <?php
    if(isset($_POST['setSlotDetails']) && isset($_POST['regular_slots_upto'])){
        $slots = $_POST['no_of_slots'];
        $_SESSION['slots'] = $slots;
        $_SESSION['regular_slots_upto'] = $_POST['regular_slots_upto'];

        ?>
        <script>
            document.getElementById("get_slot_form").style.display = "none";
        </script>
        <h3>Enter Visitors Limit for Slots.</h3>
        <form action="slot_con.php" method="post">
            <?php
            for($i = 1; $i <= $slots; $i++){
                ?>
                <div class="form-floating mb-3 w-50">
                    <input type="number" name="visitor_limit_<?php echo $i ?>" min="2" placeholder=" " id="no_of_visitors" class="form-control" required>
                    <label for="no_of_visitors">Slot <?php echo $i; ?> Visitor Limit</label>
                </div>
                <div class="row g-2">
                    <div class="col form-floating mb-3 w-75">
                        <input type="time" onchange="validate_from(<?php echo $i ?>)" name="slot_from_<?php echo $i ?>" min="2" placeholder=" " id="slot_from_<?php echo $i ?>" class="form-control" required>
                        <label for="slot_from_<?php echo $i ?>">Slot <?php echo $i; ?> From</label>
                    </div>
                    <div class="col form-floating mb-3 w-75">
                        <input type="time" onchange="validate_to<?php echo $i ?>();" name="slot_to_<?php echo $i ?>" min="2" placeholder=" " id="slot_to_<?php echo $i ?>" class="form-control" required>
                        <label for="slot_to_<?php echo $i ?>">Slot <?php echo $i; ?> To</label>
                    </div>
                </div>
                <hr>
                <script>
                    function validate_to<?php echo $i ?>(){
                        var from = document.getElementById("slot_from_<?php echo $i ?>").value;

                        if(from != ""){
                            var to = document.getElementById("slot_to_<?php echo $i ?>").value;
                            if(from > to){
                                alert("From time should be less then to time.");
                                location.href = "";
                            }
                        }else{
                            alert("From should not empty.");
                            location.href = "";
                        }
                    }
                </script>
                <?php
            }
            ?>
            <script>
                function validate_from(i){
                    var from;
                    if(document.getElementById("slot_from_1").value == ""){
                        alert("Set Slot 1 From First.")
                        location.href = "";
                    }
                    if(i != 1){
                        from = document.getElementById("slot_from_"+i).value;
                        var prev_to = document.getElementById("slot_to_"+(i-1)).value;
                        if(from < prev_to || prev_to == ""){
                            alert("Please select time after pervious slot.")
                            location.href = "";
                        }
                    }
                }
            </script>
            <button name="setRegularSlot" class="btn btn-outline-primary" type="submit">Set Regular Slot</button>                
        </form>
        <?php
    }
    ?>
    <hr>
    <hr>
    <h4 class="text-info p-4" id="schedule_slots">Set Schedule Slots with Visitors Limit</h4>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form w-75" id="get_schedule_slot_form">
        <div class="form-floating mb-4">
            <p id="schedule_slot_date_label">Schedule Slots On</p>    
            <input type="date" name="schedule_slot_date" id="schedule_slot_date" class="form-control" required>
        </div>
        <div class="form-floating mb-4">                        
            <input type="text" maxlength="150" name="reason" id="reason" class="form-control" required>
            <label for="reason">Reason for scheduling slot</label>
            <p class="text-info">Maximum 150 Character.</p>
        </div>        
        <label for="slot_limit">How much slots do you want ?</label>
        <select class="form-select" name="no_of_slots" aria-label="regular select example">
            <option value="1">01</option>
            <option selected value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
        </select>
        <button name="setScheduleSlotDetails" class="mt-5 btn btn-outline-primary" type="submit">Set Slots</button>
    </form>
    <?php
    if(isset($_POST['setScheduleSlotDetails'])){
        $slots = $_POST['no_of_slots'];
        $_SESSION['slots'] = $slots;
        $schedule_slot_date = $_POST['schedule_slot_date'];
        $_SESSION['schedule_slot_date'] = $schedule_slot_date;
        $_SESSION['schedule_reason'] = $_POST['reason'];
        
        //  Checks the slot is already created or not, if slot is created then show alert msg if not created then it will create slot.
        $chk_slot_query = "select slot_id from slots where schedule_date = '$schedule_slot_date'";
        mysqli_query($con, $chk_slot_query);    
        if($con->affected_rows > 0){
            echo "<script>alert('Slot Already Schedued on $schedule_slot_date.'); location.href = 'slots.php'</script>";
        }
        ?>
        <script>
            document.getElementById("get_schedule_slot_form").style.display = "none";
        </script>
        <h3>Enter Visitors Limit for Slots.</h3>
        <form action="slot_con.php" method="post" class="col">
            <?php
            for($i = 1; $i <= $slots; $i++){
                ?>
                <div class="form-floating mb-3 w-50">
                    <input type="number" name="visitor_limit_<?php echo $i ?>" min="2" placeholder=" " id="no_of_visitors" class="form-control" required>
                    <label for="no_of_visitors">Slot <?php echo $i; ?> Visitor Limit</label>
                </div>
                <div class="row g-2">
                    <div class="col form-floating mb-3 w-75">
                        <input type="time" onchange="validate_from(<?php echo $i ?>)" name="slot_from_<?php echo $i ?>" min="2" placeholder=" " id="slot_from_<?php echo $i ?>" class="form-control" required>
                        <label for="slot_from_<?php echo $i ?>">Slot <?php echo $i; ?> From</label>
                    </div>
                    <div class="col form-floating mb-3 w-75">
                        <input type="time" onchange="validate_to<?php echo $i ?>();" name="slot_to_<?php echo $i ?>" min="2" placeholder=" " id="slot_to_<?php echo $i ?>" class="form-control" required>
                        <label for="slot_to_<?php echo $i ?>">Slot <?php echo $i; ?> To</label>
                    </div>
                </div>
                <hr>
                <script>
                    function validate_to<?php echo $i ?>(){
                        var from = document.getElementById("slot_from_<?php echo $i ?>").value;

                        if(from != ""){
                            var to = document.getElementById("slot_to_<?php echo $i ?>").value;
                            if(from > to){
                                alert("From time should be less then to time.");
                                location.href = "";
                            }
                        }else{
                            alert("From should not empty.");
                            location.href = "";
                        }
                    }
                </script>
                <?php
            }
            ?>
            <script>
                function validate_from(i){
                    var from;
                    if(document.getElementById("slot_from_1").value == ""){
                        alert("Set Slot 1 From First.")
                        location.href = "";
                    }
                    if(i != 1){
                        from = document.getElementById("slot_from_"+i).value;
                        var prev_to = document.getElementById("slot_to_"+(i-1)).value;
                        if(from < prev_to || prev_to == ""){
                            alert("Please select time after pervious slot.")
                            location.href = "";
                        }
                    }
                }
            </script>
            <button name="setScheduleSlot" class="btn btn-outline-primary" type="submit">Set Schedule</button>
        </form>
        <?php
    }
    ?>
    
    <hr>
    <hr>
    <div id="display_slots">
        <?php
        $get_slots_query = 'select slot_id, schedule_date, reason, count(distinct slot_no) as total_slots, sum(visitor_limit) as total_visitors, schedule_time from slots GROUP BY(slot_id) order by schedule_time';
        if(isset($_GET['newest_first'])){
            $get_slots_query = "select slot_id, schedule_date, reason, count(distinct slot_no) as total_slots, sum(visitor_limit) as total_visitors, schedule_time from slots GROUP BY(slot_id) order by schedule_time desc";
        }
        if(isset($_GET['oldest_first'])){
            $get_slots_query = "select slot_id, schedule_date, reason, count(distinct slot_no) as total_slots, sum(visitor_limit) as total_visitors, schedule_time from slots GROUP BY(slot_id) order by schedule_time asc";
        }
        $slots = mysqli_query($con, $get_slots_query);
        if($con->affected_rows > 0){
            ?>
            <div class="row g-3">
                <p class="col"><b>
                    Total Vistors : 
                    <?php 
                        $total_visitors = 0;
                        while($slot = $slots->fetch_assoc()){
                            $total_visitors += $slot['total_visitors'];
                        }
                        echo $total_visitors;
                    ?>
                </b></p>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get" class="col">
                    <button type="submit" name="newest_first" value="1" class="btn btn-sm btn-outline-primary">Newest First</button>
                </form>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get" class="col">
                    <button type="submit" name="oldest_first" value="1" class="btn btn-sm btn-outline-primary">Oldest First</button>
                </form>
            </div>
            <div class="table-responsive">                

                <table class="table table-hover">
                    <tr class="bg-info">
                        <th>Slot ID</th>
                        <th>Schedule Date</th>
                        <th>Reason</th>
                        <th>Action</th>
                        <th>Slots</th>
                        <th>Schedule Time</th>
                    </tr>
                    <?php
                    $slots = mysqli_query($con, $get_slots_query);
                    while($slot = $slots->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?php echo $slot['slot_id']; ?></td>
                            <td><?php echo date("d-M-Y", strtotime($slot['schedule_date'])); ?></td>
                            <td><?php echo $slot['reason']; ?></td>
                            <td class="row g-2">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get" class="col">
                                    <button type="submit" name="slot_id" value="<?php echo $slot['slot_id']; ?>" class="btn btn-outline-primary"><i class="fa fa-eye"></i></button>
                                </form>
                            </td>
                            <td><?php echo $slot['total_slots']; ?></td>
                            <td><?php echo date("d M y H:i", strtotime($slot['schedule_time'])); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<script>
    
    // Set Regular Slots only before 10 Days.
    var regular_slots_upto =document.getElementById("regular_slots_upto");
    var regular_slots_upto_label =document.getElementById("regular_slots_upto_label");
    <?php
    $get_date_query = "select schedule_date from slots where reason like 'regular%' order by schedule_date desc limit 1";
    $slot = mysqli_query($con, $get_date_query)->fetch_assoc();
    if($con->affected_rows>0){
        $min_date = date("Y-m-d", strtotime($slot['schedule_date']));
        
        if($dt >= date("Y-m-d",strtotime("-4 day ".$min_date))){
            ?>
            regular_slots_upto.min = "<?php echo date("Y-m-d", strtotime("+1 day".$slot['schedule_date'])) ?>"
            
            regular_slots_upto.max = "<?php echo date("Y-m-d", strtotime("+18 day".$dt)) ?>"
            <?php
        }else{
            ?>
            regular_slots_upto.min = "<?php echo date("Y-m-d", strtotime("+1 day".$slot['schedule_date'])) ?>"
            regular_slots_upto.max = "<?php echo date("Y-m-d", strtotime("-1 day".$slot['schedule_date'])) ?>"
            regular_slots_upto.remove();
            regular_slots_upto_label.style.color = "red";
            regular_slots_upto_label.innerHTML = "You can set slot only after : <?php echo date("d-M-Y",strtotime("-4 day ".$min_date)); ?><br>Pervious Slot End Date is : <?php echo date("d-M-Y",strtotime($min_date)); ?>"
            <?php
        }
    }else{
        ?>
        regular_slots_upto.min = "<?php echo date("Y-m-d", strtotime($dt)) ?>"
        regular_slots_upto.max = "<?php echo date("Y-m-d", strtotime("+14 day".$dt)) ?>"
        <?php
    }
    ?>

    // Set Schedule Only Before 10 Days.
    document.getElementById("schedule_slot_date").min = "<?php echo date("Y-m-d", strtotime("+15 days ".$dt)); ?>";
    document.getElementById("schedule_slot_date").max = "<?php echo date("Y-m-d", strtotime("+30 days ".$dt)); ?>";
</script>