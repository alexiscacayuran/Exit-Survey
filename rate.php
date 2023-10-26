<!DOCTYPE html>
<html>
<head>

    <title>Exit Survey Program</title>
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
<span class="close" onclick="location.href='admin.php?class=rating'">&times;</span>
<?php

//get the corresponding question id and category of the questions from admin.php
$q_id  = $_GET['question_id'];
$class = $_GET['class'];

?>

<script>
    $(document).ready(function () {
        showGraph();
    });


    function showGraph()
    {
        {
            
            //get the tally of rating for each question in json format from rate_data, 
            //rate_data.php is sensitive so no comments are allowed in the file
            $.post("rate_data.php?q_id=<?php echo $q_id ?>",
            function (data)
            {
                //assign the data choices to each of the chart variables from rate_data
                console.log(data);
                var zero = data[0].zero;
                var one = data[0].one;
                var two = data[0].two;
                var three = data[0].three;
                var four = data[0].four;
                var five = data[0].five;



                var chartdata = {
                    labels: [
                        'Not Applicable',
                        'Needs Improvement',
                        'Poor',
                        'Satisfactory',
                        'Good',
                        'Excellent'
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
                            ],
                            data: [
                                zero,
                                one,
                                two,
                                three,
                                four,
                                five
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

<?php

//check if the category is Degree Program
if ($class == 'Degree Program') {

    //select the rateable questions from the questionnaire
    $select1 = "SELECT question_id, question, rateable FROM questionnaire";
    $result1 = mysqli_query($conn, $select1);

    if (mysqli_num_rows($result1) > 0) {
        while ($row = mysqli_fetch_assoc($result1)) {
            if ($row['rateable'] == 'True' && $row['question_id'] == $q_id) {

                //get the respondent and their rate of that particular question
                $rate = "SELECT demographics.full_name, demographics.up_mail, rating.rate
            FROM demographics NATURAL JOIN rating
            WHERE (demographics.id = rating.id) AND rating.question_id ='$q_id'";
                $rate_result = mysqli_query($conn, $rate);

                ?>


    <div align="center">
        <table width="100%">
            <tr>

                <!-- print the question -->
                <td colspan="2" style="font-size: 18px; font-weight: bolder"><?php echo $row['question'] ?></td>
            </tr>
            <tr>
                <td style="width: 50%;" rowspan="3">

                <!-- chart showing the rating for the question -->
                <div  id="chart-container" style="margin: 30px">
                    <p align="center" style="font-weight: bold; padding: 0px 0px 0px 0px;">Question Scores</p>
                    <canvas id="graphCanvas"></canvas>
                </div>


                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <th align="center" style="width: 280px">Name</th>
                        <th align="center" style="width: 33px">Rate</th>
                    </table>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <!-- show the respondent and their rate in list form -->
                    <div class="rate-list">
                        <ul>
                        <?php

                $i = 1;
                if (mysqli_num_rows($rate_result) > 0) {
                    while ($row = mysqli_fetch_assoc($rate_result)) {
                        ?>
                        <li>
                            <table class="border-bot" width="100%">
                                <tr>
                                    <td valign="top" style="width: 280px">
                                        <?php
                        echo $i . ". ";

                        //print the name or their email
                        if ($row['full_name'] == null) {
                            echo $row['up_mail'];
                        } else {
                            echo $row['full_name'];}
                        ?>
                                    </td>
                                    <!-- print their rate -->
                                    <td valign="top" align="center" style="width: 33px"><?php echo $row['rate'] ?></td>
                                </tr>
                            </table>
                            </li>

                        <?php
$i++;
                    }
                }
                ?>
                    </ul>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <?php
}
        }
    }
}?>


<?php

//check if the category is Facilities and Infrastructure
if ($class == 'Facilities and Infrastructure') {

    //select the rateable questions which in this case the facilities from the questionnaire
    $select1 = "SELECT question_id, question, rateable FROM questionnaire";
    $result1 = mysqli_query($conn, $select1);

    if ($q_id >= '16' && $q_id <= '28') {
        ?>
    <!-- print the question -->
    <p>How will you rate the following services provided by the following offices?</p>
<?php
}

    if (mysqli_num_rows($result1) > 0) {
        while ($row = mysqli_fetch_assoc($result1)) {
            if ($row['rateable'] == 'True' && $row['question_id'] == $q_id) {

                //get the respondent and their rate of that particular facility
                $rate = "SELECT demographics.full_name, demographics.up_mail, rating.rate
            FROM demographics NATURAL JOIN rating
            WHERE (demographics.id = rating.id) AND rating.question_id ='$q_id'";
                $rate_result = mysqli_query($conn, $rate);

                ?>
 <div align="center">
        <table width="100%">
            <tr>
                <!-- print the facility -->
                <td colspan="2" style="font-size: 18px; font-weight: bolder"><?php echo $row['question'] ?></td>
            </tr>
            <tr>
                <td style="width: 50%;" rowspan="3">

                <!-- chart showing the rating for the facility -->
                <div  id="chart-container" style=" margin: 30px">
                    <p align="center" style="font-weight: bold; padding: 0px 0px 0px 0px;">Question Scores</p>
                    <canvas id="graphCanvas"></canvas>
                </div>


                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <th align="center" style="width: 280px">Name</th>
                        <th align="center" style="width: 33px">Rate</th>
                    </table>
                </td>
            </tr>
            <tr>
                <td  valign="top" style="padding: 10px">
                    <!-- show the respondent and their rate in list form -->
                    <div class="rate-list">
                        <ul>
                        <?php

                $i = 1;
                if (mysqli_num_rows($rate_result) > 0) {
                    while ($row = mysqli_fetch_assoc($rate_result)) {
                        ?>
                        <li>
                            <table class="border-bot" width="100%">
                                <tr>
                                    <td valign="top" style="width: 280px">
                                        <?php
                        echo $i . ". ";

                        //print the name or their email
                        if ($row['full_name'] == null) {
                            echo $row['up_mail'];
                        } else {
                            echo $row['full_name'];}
                        ?>
                                    </td>
                                    <!-- print their rate -->
                                    <td valign="top" align="center" style="width: 33px"><?php echo $row['rate'] ?></td>
                                </tr>
                            </table>
                            </li>

                        <?php
$i++;
                    }
                }
                ?>
                    </ul>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <?php
}
        }
    }
}?>

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