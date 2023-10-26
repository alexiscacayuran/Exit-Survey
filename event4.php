<!DOCTYPE html>
<html>
<head>

    <title>Admin | DMCS Exit Survey</title>
    <!-- styles and font-->
    <link rel="icon" href="https://cs.upb.edu.ph/assets/images/upbcs-logo.png">
    <link rel="stylesheet" href="survey-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'></script>
</head>
<body>
<?php
//show an error message if access directly
define('MyConst', true);

//connect to the database
include_once 'connection.php';

//filter the accesses on this file
session_start();
$_SESSION['gatekeep1'] = false;
$_SESSION['gatekeep2'] = false;

if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    die();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ./login.php");
    exit;
}

if ($_SESSION['type'] != 1) {
    session_destroy();
    header("Location: login.php");
    die();
}

?>



<!-- modal -->
<div class="modal" id="myModal">

<!-- modal content -->
<div class="modal-content">
<span class="close" onclick="location.href='admin.php?class=suggestion'">&times;</span>
<?php
//get the corresponding question id of the question from admin.php
$q_id = $_GET['question_id'];

//select the question from the questionnaire
$select1 = "SELECT * FROM questionnaire where question_id = $q_id";
$result1 = mysqli_query($conn, $select1);

if (mysqli_num_rows($result1) > 0) {
    while ($row = mysqli_fetch_assoc($result1)) {
        ?>
            <!-- print the question -->
            <p style="font-size: 18px; font-weight: bolder; padding: 10px"><?php echo $row['question'] ?></p>
<?php
}
}

//counters for each of the data choices
$ctr1 = 0;
$ctr2 = 0;
$ctr3 = 0;
$ctr4 = 0;
$ctr5 = 0;
$ctr6 = 0;
$ctr9 = 0;

//fetch the answer for the question from the database
$sel  = "SELECT * FROM suggestion where question_id = $q_id";
$res  = mysqli_query($conn, $sel);

if (mysqli_num_rows($res) > 0) {
    while ($row1 = mysqli_fetch_assoc($res)) {
        
        //extract the data choices from the concatenated answer and put it to array
        $str_arr = explode(", ", $row1['comments']);
        
        //count the occurence of the data choices
        $count = count($str_arr);
        for ($x = 0; $x < $count; $x++) {
            if ($str_arr[$x] == "Scientific Research") {
                $ctr1++;
            } else if ($str_arr[$x] == "Graduate School") {
                $ctr2++;
            } else if ($str_arr[$x] == "Teaching") {
                $ctr3++;
            } else if ($str_arr[$x] == "NGO") {
                $ctr4++;
            } else if ($str_arr[$x] == "Government") {
                $ctr5++;
            } else if ($str_arr[$x] == "Private Sector") {
                $ctr6++;
            } else {
                $ctr9++;
            }
        }
    }
}


?>

<script>
    $(document).ready(function () {
        showGraph();
    });


    function showGraph()
    {
        {
            $.post("",
            function (data)
            {
                //assign the data choices to each of the chart variables
                var zero = <?php echo $ctr1 ?>;
                var one = <?php echo $ctr2 ?>;
                var two = <?php echo $ctr3 ?>;
                var three = <?php echo $ctr4 ?>;
                var four = <?php echo $ctr5 ?>;
                var five = <?php echo $ctr6 ?>;
                var eight = <?php echo $ctr9 ?>;

                var chartdata = {
                    labels: [
                        'Scientific Research',
                        'Graduate School',
                        'Teaching',
                        'NGO',
                        'Government',
                        'Private Sector',
                        'Others'
                    ],
                    datasets: [
                        {
                            label: 'Respondents',
                            backgroundColor: [
                              '#F4511E',
                              '#FB8C00',
                              '#FFB300',
                              '#FDD835',
                              '#7CB342',
                              '#43A047',
                              'darkgreen',
                              'turquoise',
                              'skyblue'
                            ],
                            data: [
                                zero,
                                one,
                                two,
                                three,
                                four,
                                five,
                                eight
                            ],
                            hoverOffset: 4,
                            borderColor: '#FFFFFF'
                        }
                    ]
                };

                var graphTarget = $("#graphCanvas");

                var barGraph = new Chart(graphTarget, {
                    type: 'doughnut',
                    data: chartdata,
                    options: {
                        plugins: {
                            legend: {
                                position: 'left'
                            }
                        }
                    }



                });
            });
        }
    }
</script>
                <!-- chart showing the tally of answers for the question -->
                <div align="center">
                <div  id="chart-container" style="width: 350px; height: 40%; margin: 0 80px 30px 80px">
                    <p align="center" style="font-weight: bold; padding: 0px 0px 0px 0px;">Question Scores</p>
                    <div style="margin: 0px 30px">
                    <canvas id="graphCanvas"></canvas>
                    </div>
                </div>
                </div>



</div>
</div>




</body>
<script>

// show the modal
var modal = document.getElementById("myModal");

window.onload = function(){
    modal.style.display = "block";
}

</script>