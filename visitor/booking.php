<?php
require "visitor_navbar.php";

if(isset($_POST['select_date'])){

    $visit_date = $_POST['visit_date'];
    
    $_SESSION['visit_date'] = $visit_date;
    $_SESSION['fees'] = $fees['fees'];
        
    $chk_slot = "select *from slots where '$visit_date' <= schedule_date and (reason like 'regular%' || reason like 'schedule%') order by schedule_date ";
    
    $slots = mysqli_query($con, $chk_slot);
    $get_slot_details_query = '';
    $isSchedule = 'false';
    if($con->affected_rows > 0){
        while($slot = $slots->fetch_assoc()){
            
            if($visit_date == $slot['schedule_date']){
                $isSchedule = $slot['slot_id'];
                break;
            }else{
                $isSchedule = $slot['slot_id'];
            }
        }
    }
    if($isSchedule != "false"){
        $get_slot_details_query = "select *from slots where slot_id = '$isSchedule'";
    }
    $slots = mysqli_query($con, $get_slot_details_query)->fetch_assoc();
    if($con->affected_rows > 0){
        ?>
        <div class="container mt-5 table-responsive">
            <p class="text-info"><b>
                Slot ID : <?php echo $slots['slot_id']; ?> <br>
                Schedule Date : <?php echo $slots['schedule_date']; ?> <br>
                Visiting Date : <?php echo date("d-M-Y", strtotime($visit_date)); ?>
                </b>
            </p>
            <table class="table table-hover">
                <tr class="bg-secondary">
                    <th>Slot No</th>
                    <th>Book</th>
                    <th>Slot From</th>
                    <th>Slot To</th>
                    <th>Availablity</th>
                    <th>Visitor</th>
                </tr>
                <?php
                $slot_id = $slots['slot_id'];
                $get_slot_details_query = "select *from slots where slot_id = '$slot_id'";
                $slots = mysqli_query($con, $get_slot_details_query);
                while($slot = $slots->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $slot['slot_no']; ?></td>
                        <td>
                            <button type="submit" value="<?php echo $slot['slot_no']; ?>" class="btn btn-outline-primary" data-bs-slot_id="<?php echo $slot_id; ?>" data-bs-slot_no="<?php echo $slot['slot_no']; ?>" data-bs-toggle="modal" data-bs-target="#bookTicketModal"><i class="fa fa-ticket"></i></button>
                        </td>
                        <td><?php echo $slot['slot_from']; ?></td>
                        <td><?php echo $slot['slot_to']; ?></td>
                        <td>
                            <?php
                                $remaining_availability = 0;
                                $slot_visitor_limit = $slot['visitor_limit'];
                                $chk_book_avail = "select no_of_members as members, slot_id, slot_no from bookings where visiting_date = '$visit_date'";
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
    }    
}
if(isset($_POST['chk_availability'])){
    $visitor_id = $_SESSION['visitor']['visitor_id'];
    $slot_id = $_POST['slot_id'];
    $slot_no = $_POST['slot_no'];
    $no_of_members = $_POST['no_of_members'];
    
    $_SESSION['slot_id'] = $slot_id;
    $_SESSION['slot_no'] = $slot_no;
    $_SESSION['no_of_members'] = $no_of_members;

    $member_names = "";
    $member_ages = "";
    $member_genders = "";
    for($i=1; $i <= $no_of_members; $i++){
        $member_names = $member_names. "," .$_POST['member'.$i];
        $member_ages = $member_ages. "," . $_POST['memberAge'. $i];
        $member_genders = $member_genders. "," . $_POST['memberGender'. $i];
    }
    $member_names = ltrim($member_names, ",");
    $member_ages = ltrim($member_ages, ",");
    $member_genders = ltrim($member_genders, ",");

    // Assisgning Member Information to Session Values.
    $_SESSION['member_names'] = $member_names;
    $_SESSION['member_ages'] = $member_ages;
    $_SESSION['member_genders'] = $member_genders;

    //  Check Availability Remained..
    $get_slot_details_query = "select *from slots where slot_id = '$slot_id'";
    $slots = mysqli_query($con, $get_slot_details_query)->fetch_assoc();

    $slots = mysqli_query($con, $get_slot_details_query);
    $availability = true;
    $available_ticket = 0;
    while($slot = $slots->fetch_assoc()){
        $remaining_availability = 0;
        $slot_visitor_limit = $slot['visitor_limit'];

        $visit_date = $_SESSION['visit_date'];

        $chk_book_avail = "select no_of_members as members, slot_id, slot_no from bookings where visiting_date = '$visit_date'";
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
        if($remaining_availability < $no_of_members){
            $availability = false;
            $available_ticket = $remaining_availability;
        }
    }
    if($availability){
        ?>
        <form action="payment/index.php" method="post" class="justify-content-center text-center m-5">
            <p class="text-info">Click Below Button to Pay Your Fees and Book Ticket..!</p>
            <p class="text-warning text-left">                
                Visiting Date : <b><?php echo $_SESSION['visit_date']; ?></b>.<br>With <b><?php echo $_POST['no_of_members']; ?></b> Visitor Details.<br>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr class="bg-primary">
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                        </tr>
                        <?php
                        for($i=0;$i< $_POST['no_of_members']; $i++){
                            ?>
                            <tr>
                                <td><?php echo $i+1; ?></td>
                                <td><?php echo explode(",", $member_names)[$i]; ?></td>
                                <td><?php echo explode(",", $member_ages)[$i]; ?></td>
                                <td><?php echo explode(",", $member_genders)[$i]; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                Total Fees : <b><?php echo $_SESSION['fees'] * $_POST['no_of_members']; ?></b>
            </p>
            <input type="hidden" name="visitor_name" value = "<?php echo $_SESSION['visitor']['visitor_fname']. " ". $_SESSION['visitor']['visitor_lname']; ?>">            
            <input type="hidden" name="visitor_id" value = "<?php echo $_SESSION['visitor']['visitor_id'] ?>">
            <input type="hidden" name="visitor_email" value = "<?php echo $_SESSION['visitor']['visitor_email'] ?>">
            <button type="submit" name="pay_fees" class="btn btn-outline-primary">Pay Fees</button>
        </form>
        <?php
    }else{
        ?>
        <div class="mt-5 container alert alert-warning alert-dismissible fade show" role="alert">
            <strong><?php echo $available_ticket." Tickets Avaiable on ".date("d-M-Y", strtotime($visit_date)); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    }
}


?>
<div class="container container shadow mt-5">
    <h3 class="text-info p-3">Book Your Ticket</h3>
    <p class="text-info p-4" style="font-size: 15px; font-family: monospace;"><span class="fs-4">Plan a sweet date with all things historical.</span><br><b>Per Person Fees : <?php echo $fees['fees']; ?> Rs /-</b></p>    
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form p-3">
        <div class="form-floating mb-4">
            <input type="date" name="visit_date" id="visit_date" class="form-control" required>
            <label for="visit_date">Select Visit Date</label>
        </div>
        <button name="select_date" class="btn btn-outline-success"><i class="fa fa-ticket"></i> Book Now</button>
    </form>
</div>
<div class="modal fade" id="bookTicketModal" tabindex="-1" aria-labelledby="bookTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookTicketModalLabel"></h5>
                <button typed="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <div class="mb-3 form-floating">
                        <input type="text" name="slot_id" id="slot_id" class="form-control" readonly />
                        <label for="slot_id">Slot ID</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" name="slot_no" id="slot_no" class="form-control" readonly />
                        <label for="slot_no">Slot Number</label>
                    </div>                    
                    <div class="mb-3 form-floating">
                        <select class="form-select" onchange="create_name_inputs()" name="no_of_members" id="no_of_members" aria-label="regular select example">
                            <option value="1">No. of members : 01</option>
                            <option value="2">No. of members : 02</option>
                            <option value="3">No. of members : 03</option>
                            <option value="4">No. of members : 04</option>
                            <option value="5">No. of members : 05</option>
                            <option value="6">No. of members : 06</option>
                            <option value="7">No. of members : 07</option>
                        </select>
                    </div>
                    <div id="member_names">
                        <button id="removeRow" type="button" class="m-2 btn btn-outline-danger">Reset</button>
                        <div id="member_names_inputs">
                            <input type="text" name="member1" placeholder="Enter member name" title="Enter Only Characters" pattern="^[A-Za-z ]+$" id="member1" maxlength="100" required class="form-control mb-3">
                            <input type="text" name="memberAge1" placeholder="Enter member Age" title="Enter Only Numbers" pattern="^[0-9]+$" id="age1" min="6" max="100" required class="form-control mb-3">
                            <input type="radio" name="memberGender1" value="male" title="Male" class="fs-2 fa fa-male btn btn-outline-info form-check-input mx-3" checked>
                            <input type="radio" name="memberGender1" value="female" title="Female" class="fs-2 fa fa-female btn btn-outline-info form-check-input mx-3">
                        </div>
                    </div>
                    <div class="modal-footer my-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="chk_availability" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function create_name_inputs(){
        var members = document.getElementById("no_of_members").value;
        var member_names_div = document.getElementById("member_names_inputs");

        // document.body.querySelector("#member_names").remove(input);
        for(var i=1; i <= members; i++){
                if(document.getElementById("member"+i) == null){
                    var  nameInput= document.createElement("INPUT");
                    nameInput.setAttribute("type", "text");
                    nameInput.setAttribute("class", "members form-control my-3");
                    nameInput.setAttribute("name", "member"+(i));
                    nameInput.setAttribute("id", "member"+(i));
                    nameInput.setAttribute("required", "true");
                    nameInput.setAttribute("maxlength", "100");
                    nameInput.setAttribute("pattern", "^[A-Za-z ]+$");
                    nameInput.setAttribute("title", "Enter Only Characters");
                    nameInput.setAttribute("placeholder", "Enter member "+i+" name");
                    
                    var  ageInput= document.createElement("INPUT");
                    ageInput.setAttribute("type", "number");
                    ageInput.setAttribute("class", "members form-control mb-3");
                    ageInput.setAttribute("name", "memberAge"+(i));
                    ageInput.setAttribute("id", "memberAge"+(i));
                    ageInput.setAttribute("required", "true");
                    ageInput.setAttribute("max", "100");
                    ageInput.setAttribute("min", "6");
                    ageInput.setAttribute("pattern", "^[0-9]+$");
                    ageInput.setAttribute("title", "Enter Only Numbers");
                    ageInput.setAttribute("placeholder", "Enter member "+i+" Age");

                    var  maleRadio= document.createElement("INPUT");
                    maleRadio.setAttribute("type", "radio");
                    maleRadio.setAttribute("class", "fs-2 fa fa-male members btn btn-outline-info form-check-input mx-3");
                    maleRadio.setAttribute("name", "memberGender"+(i));
                    maleRadio.setAttribute("id", "memberGender"+(i));
                    maleRadio.setAttribute("value", "male");
                    maleRadio.setAttribute("checked", "true");
                    maleRadio.setAttribute("title", "Male");

                    var  femaleRadio= document.createElement("INPUT");
                    femaleRadio.setAttribute("type", "radio");
                    femaleRadio.setAttribute("class", "fs-2 fa fa-female members btn btn-outline-info form-check-input mx-3");
                    femaleRadio.setAttribute("name", "memberGender"+(i));
                    femaleRadio.setAttribute("id", "memberGender"+(i));
                    femaleRadio.setAttribute("value", "female");
                    femaleRadio.setAttribute("title", "Female");

                    document.body.querySelector("#member_names").appendChild(nameInput);
                    document.body.querySelector("#member_names").appendChild(ageInput);
                    document.body.querySelector("#member_names").appendChild(maleRadio);
                    document.body.querySelector("#member_names").appendChild(femaleRadio);
                }
        }
    }

    // remove member names input
    $(document).on('click', '#removeRow', function () {
        const member_name_inputs = document.getElementsByClassName("members");
        while(member_name_inputs.length > 0){
            member_name_inputs[0].parentNode.removeChild(member_name_inputs[0]);
        }
        document.getElementById("no_of_members").options.item(0).selected = true;
    });

    <?php

    // Get Recent Regular Slots.
    $get_date_query = "select schedule_date from slots where reason like 'regular%' order by schedule_date desc limit 1";
    $slot= mysqli_query($con, $get_date_query)->fetch_assoc();
    if($con->affected_rows >= 0){
        ?>
        document.getElementById("visit_date").min = "<?php echo date("Y-m-d", strtotime($dt)); ?>";
        document.getElementById("visit_date").max = "<?php echo $slot['schedule_date']; ?>";
        <?php
    }else{
        echo "alert('No Slots Exists...'); location.href=  'index.php'";
    }
    ?>

    
    var bookTicketModal = document.getElementById('bookTicketModal')
    bookTicketModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        
        var data_slot_id = button.getAttribute('data-bs-slot_id')
        var data_slot_no = button.getAttribute('data-bs-slot_no')
        
        var slot_no = document.getElementById("slot_no");
        slot_no.value = data_slot_no
        var slot_id = document.getElementById("slot_id");
        slot_id.value = data_slot_id
    })
</script>