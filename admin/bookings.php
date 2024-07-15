<?php
require "admin_navbar.php";


// Get Genders and ages

$filter_visitors_query = "select no_of_members, member_details from bookings";
$filtered_visitors = mysqli_query($con, $filter_visitors_query);

if($con->affected_rows > 0){
    $male = $female = 0;
    $ages = array();
    $i = 0;
    $genders = "";
    while($visitor = $filtered_visitors->fetch_assoc()){
        
        $genders = explode("|", $visitor['member_details'])[2];
        $ages_explode = explode("|", $visitor['member_details'])[1];

        for($m=0; $m< $visitor['no_of_members']; $m++){
            if(explode(",", $genders)[$m] == "male")
                $male = $male + 1;
            if(explode(",", $genders)[$m] == "female")
                $female = $female + 1;
            // $ages = $ages .explode(",", $ages_explode)[$m];
            array_push($ages, explode(",", $ages_explode)[$m]);
        }
    }

    $gender = array( 
        array("label"=>"male", "y"=>$male/($male + $female) * 100),
        array("label"=>"Female", "y"=>$female/($male + $female) * 100),
    );

    $under_18 = $under_50 = $under_100 = 0;
    for($i=0; $i<sizeof($ages); $i++){

        if($ages[$i] >= 6 && $ages[$i] <= 18)
            $under_18++;
        if($ages[$i] > 18 && $ages[$i] <= 50)
            $under_50++;
        if($ages[$i] > 50 && $ages[$i] <= 100)
            $under_100++;
    }

    $age_filter = array(    
        array("label"=>"06 - 18", "y"=>$under_18/sizeof($ages) * 100),
        array("label"=>"19 - 50", "y"=>$under_50/sizeof($ages) * 100),
        array("label"=>"51 - 100", "y"=>$under_100/sizeof($ages) * 100),
    );
    ?>
    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("genderPieChart", {
                theme: "light2",
                animationEnabled: true,
                title: {
                    text: "Gender Of Visitors"
                },
                data: [{
                    type: "pie",
                    indexLabel: "{y}",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabelPlacement: "inside",
                    indexLabelFontColor: "#36454F",
                    indexLabelFontSize: 18,
                    indexLabelFontWeight: "bolder",
                    showInLegend: true,
                    legendText: "{label}",
                    dataPoints: <?php echo json_encode($gender, JSON_NUMERIC_CHECK); ?>
                }]
            });

            chart.render();

            var chart1 = new CanvasJS.Chart("agePieChart", {
                theme: "light2",
                animationEnabled: true,
                title: {
                    text: "Age Of Visitors"
                },
                data: [{
                    type: "pie",
                    indexLabel: "{y}",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabelPlacement: "inside",
                    indexLabelFontColor: "#36454F",
                    indexLabelFontSize: 18,
                    indexLabelFontWeight: "bolder",
                    showInLegend: true,
                    legendText: "{label}",
                    dataPoints: <?php echo json_encode($age_filter, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart1.render();    
        }
    </script>

    <div class="container mt-5 row g-3">
        <h2>Booking Details with Pie Chart Representation</h2>
        <div id="genderPieChart" style="height: 370px; width: 100%;" class="col"></div>
        <div id="agePieChart" style="height: 370px; width: 100%;" class="col"></div>
    </div>

    <div class="container mt-5 shadow p-4">
        <h2 class="p-4">Booking Details</h2>
        <?php
            if(isset($_POST['getBookings'])){
                
                $bookings_from = $_POST['bookings_from'];
                $bookings_to = $_POST['bookings_to'];
                
                $bookings_from = str_replace("T", " ", $bookings_from);
                $bookings_to = str_replace("T", " ", $bookings_to);

                $filter_booking_query = "select visitor_id, booking_id, slot_id from bookings where book_time between '$bookings_from' and '$bookings_to'";
                $bookings = mysqli_query($con, $filter_booking_query);

                if($con->affected_rows > 0){
                    ?>
                    <h3 class="text-info">Bookings Details From <?php echo $bookings_from; ?> to <?php echo $bookings_to; ?></h3>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr class="bg-primary">
                                <th>Visitor ID</th>
                                <th>Booking ID</th>
                                <th>Slot ID</th>
                            </tr>
                            <?php
                            while($booking = $bookings->fetch_assoc()){
                                ?>
                                <tr>
                                    <td><?php echo $booking['visitor_id']; ?></td>
                                    <td><a href="../check_booking.php?id=<?php echo $booking['booking_id']; ?>" target="__blank"><?php echo $booking['booking_id']; ?></a></td>
                                    <td><?php echo $booking['slot_id']; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><?php echo "No booking from ".$bookings_from." to ".$bookings_to; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>                
                    <?php
                }

            }
        ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form w-75 mb-5">
            <div class="row">
                <div class="form-floating mb-3 col">
                    <input type="datetime-local" name="bookings_from" class="form-control" required>
                    <label class="px-4" for="from">Bookings From</label>
                </div>
                <div class="form-floating mb-3 col">
                    <input type="datetime-local" name="bookings_to" id="bookings_to" class="form-control" required>
                    <label class="px-4" for="to">Bookings TO</label>
                </div>
            </div>
            <button name="getBookings" value="true" class="btn btn-outline-success" type="submit">GET ALL BOOKINGS</button>
        </form>
        
        <div class="table-responsive">
            <h3>All Booking Details</h3>
            <table class="table table-hover">
                <tr class="bg-success">
                    <th>Visitor ID</th>
                    <th>Booking ID</th>
                    <th>Slot ID</th>
                </tr>
                <?php
                $get_booking_query = "select visitor_id, booking_id, slot_id from bookings";
                $bookings = mysqli_query($con, $get_booking_query);
                while($booking = $bookings->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo $booking['visitor_id']; ?></td>
                        <td><a href="../check_booking.php?id=<?php echo $booking['booking_id']; ?>" target="__blank"><?php echo $booking['booking_id']; ?></a></td>
                        <td><?php echo $booking['slot_id']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <script>
            // Maximum  limit of booking to is : current time.
            <?php 
                $today = str_replace(" ", "T", $dt);
            ?>
            document.getElementById("bookings_to").max = "<?php echo $today; ?>"
        </script>
    </div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php
}else{
?>
    <h3 class="container mt-5 p-5 shadow text-info">No Bookings Yet..!</h3>
<?php
}
?>