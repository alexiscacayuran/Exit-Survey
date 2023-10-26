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

//connect to database
include_once 'connection.php';

//filter accesses on this file
session_start();
$_SESSION['gatekeep1'] = false;

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

//get class to pick which results to show
$class = $_GET['class'];
?>

    <div class="container">
    <div class="admin">
    <div class="row d-flex justify-content-center align-items-center">

    <!-- scroll up button -->
    <button onclick="topFunction()" id="scrolltop-btn" title="Go to top"><i class="fa fa-arrow-up"></i></button>

    <!-- script for the scroll up button -->
    <script>
        
        //get the button:
        mybutton = document.getElementById("scrolltop-btn");

        //when the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
          if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
          } else {
            mybutton.style.display = "none";
          }
        }


        // when the user clicks on the button, scroll to the top of the document
        function topFunction() {
          document.documentElement.scrollTop = 0; 
        }
     </script>

     <script>
        // toggle loading animation
        function loading() {
            var x = document.getElementsByClassName("loader");
            x[0].style.display = "block";
            var y = document.getElementById("frm-restore");
            y.style.display = "none";
        }
    </script>

   


    <!-- container-->
    <div id="regForm">

    	<!-- sign out button -->
        <div style="position: relative; height: 40px; padding-left: 50px; float: right" id="nextprevious">
            <div class="center">
                    <form action="" method="post">
                   <button id="signoutBtn" title="Log Out" type="submit" name="logout" value="Log Out"><i class="fa fa-sign-out"></i></button>
                   </form>
            </div>
        </div>

        <!-- download total tally button -->
        <div style="position: relative; height: 40px; padding-left: 160px; float: left" id="nextprevious">
            <div class="center">
                  <button id="btn" title="Download Total Tally" type="button" onclick="location.href='restotal_download.php'" style="font-size: 12px"><i class="fa fa-download"></i>  Download Total</button>
            </div>
        </div>


         <!-- restore button, clicking will open a modal -->	
        <div style="position: relative; height: 40px; padding-left: 50px; float: right" id="nextprevious">
            <div class="center">
                <button id="myBtn" class="btn-modal" title="Restore" type="button"><i class="fa fa-history"></i></button>
            </div>
        </div>



        <!-- the modal for restore -->
        <div id="myModal" class="modal">

          <!-- modal content -->
          <div class="modal-content" action="backup.php" style="width: 30%; height: auto; padding: 50px">
            <span class="close">&times;</span>
            <div align="center" width="100%">

            <h3 style="font-size: 20px; font-weight: bolder">Restore</h3>


             <!-- choose which file to use for restoring the database -->
            <form method="post" action="" enctype="multipart/form-data" id="frm-restore">
                <div class="file-picker-container">
                    <p style="font-size: 16px">Choose the SQL backup file you wish to use.</p>
                    <div  style="margin: 20px" align="center">
                        <input style="width: 90%" type="file" name="backup_file" class="input-file" />
                    </div>
                </div>


             <!-- confirmation buttons -->
            <button id="normal-btn" style="margin-right: 5px;" type="submit" title="Restore" value="Restore" onclick="loading()">Restore</button>
            <button id="normal-btn" style="float: none" class="close">Cancel</button>
            </form>
            <div style="margin: 20px;"><div class="loader" style="width: 80px; height: 80px; display: none"></div></div>
            </div>
          </div>

        </div>

   <!-- script for the modal -->
  <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];


        // When the user clicks the button, open the modal
        btn.onclick = function() {
          modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
          modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }
        </script>

<?php
//get and validate the sql file
if (!empty($_FILES)) {

    // validating SQL file type by extensions
    if (!in_array(strtolower(pathinfo($_FILES["backup_file"]["name"], PATHINFO_EXTENSION)), array(
        "sql",
    ))) {
        $response = array(
            "type"    => "error",
            "message" => "Invalid File Type",
        );
    } else {
        if (is_uploaded_file($_FILES["backup_file"]["tmp_name"])) {
            move_uploaded_file($_FILES["backup_file"]["tmp_name"], $_FILES["backup_file"]["name"]);

            $response = restoreMysqlDB($_FILES["backup_file"]["name"], $conn);
        }
    }
}

//restore function
function restoreMysqlDB($filePath, $conn)
{

    $conn->query('SET foreign_key_checks = 0');
    if ($result = $conn->query("SHOW TABLES")) {
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $conn->query('DROP TABLE IF EXISTS ' . $row[0]);
            
        }
    }

    $conn->query('SET foreign_key_checks = 1');

    $sql   = '';
    $error = '';

    if (file_exists($filePath)) {
        $conn->query('SET foreign_key_checks = 0');
        $lines = file($filePath);

        foreach ($lines as $line) {

            // Ignoring comments from the SQL script
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

            $sql .= $line;

            if (substr(trim($line), -1, 1) == ';') {
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    $error .= mysqli_error($conn) . "\n";
                }
                $sql = '';
            }
        }
        
    } // end if file exists
    
}
?>


		 <!-- backup button -->
        <div style="position: relative; height: 40px; padding-left: 50px; float: right" id="nextprevious">
            <div class="center">


                  <button id="nextBtn" title="Backup" type="button" onclick="location.href='backup.php'"><i class="fa fa-save"></i></i></button>
            </div>
        </div>





         <!-- manage users button -->
        <div style="position: relative; height: 40px; padding-left: 160px; float: left" id="nextprevious">
            <div class="center">
                   <button id="btn" title="Manage Users" type="button" onclick="location.href='user.php'" style="font-size: 12px"><i class="fa fa-user"></i>  Manage Users</button>
            </div>
        </div>


        <div align="center">
        <h1 style="margin: 100px 0px 40px 0px; font-size: 40px">DMCS Exit Survey</h1>
        </div>


         <!-- sidebar for the list of respondents-->
        <div class="sidebar" style="height: auto">
        <div align="center">
             <h3>Respondents</h3>
        </div>
        <div class="list" style="max-height: 500px">
        <ul>
             <?php

//query to show all the respondents
$select_resp = "SELECT id, up_mail, full_name, student_num, degree_program FROM demographics WHERE time_out != ''";
$result_resp = mysqli_query($conn, $select_resp);

if (mysqli_num_rows($result_resp) > 0) {
    while ($row = mysqli_fetch_assoc($result_resp)) {
        ?>
            <li class="border-bot">
                <p onclick="location.href='res_individual.php?id=<?php echo $row['id'] ?>&class=<?php echo "Degree Program" ?>';">
                    <?php

        $max = 21;

        if ($row['full_name'] == null) {
            if (strlen($row['up_mail']) > $max) {
                echo substr($row['up_mail'], 0, $max) . "...";
            } else {
                echo $row['up_mail'];
            }

        } else {
            if (strlen($row['full_name']) > $max) {
                echo substr($row['full_name'], 0, $max) . "...";
            } else {
                echo $row['full_name'];
            }

        }?>
                </p>
            </li>

            <?php
}
}?>
        </ul>
        </div>
    </div>

    <div class="main">

    <?php

//get the count of respondents from BS Computer Science, then add to demog_graph table
$countdeg1        = "SELECT COUNT(degree_program) as count FROM demographics WHERE degree_program = 'BS Computer Science'";
$result_countdeg1 = mysqli_query($conn, $countdeg1);

if (mysqli_num_rows($result_countdeg1) > 0) {
    while ($row = mysqli_fetch_assoc($result_countdeg1)) {

        $count  = $row['count'];
        $update = "UPDATE demog_graph SET count = '$count' WHERE degree_program = 'BS Computer Science'";

        if ($conn->query($update) && false) {
            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
        }
    }
}

//get the count of respondents from BS Mathematics, then add to demog_graph table
$countdeg2        = "SELECT COUNT(degree_program) as count FROM demographics WHERE degree_program = 'BS Mathematics'";
$result_countdeg2 = mysqli_query($conn, $countdeg2);

if (mysqli_num_rows($result_countdeg2) > 0) {
    while ($row = mysqli_fetch_assoc($result_countdeg2)) {

        $count  = $row['count'];
        $update = "UPDATE demog_graph SET count = '$count' WHERE degree_program = 'BS Mathematics'";

        if ($conn->query($update) && false) {
            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
        }
    }
}

?>

	<!-- chart showing the respondents from the two programs -->
    <div align="center" style="height: 250px">
        <div class="left-half">
         <div  id="chart-container" style="background-color: #f1f1f1; padding: 20px; border-radius: 10px;">
            <span style="font-weight: bold; padding: 10px">No. of Respondents</span>
            <canvas id="graphCanvas"></canvas>
        </div>
        </div>

<!-- query to count the total number of students  -->
<?php
$total        = "SELECT COUNT(id) as total FROM demographics WHERE time_out != ''";
$result_total = mysqli_query($conn, $total);

if (mysqli_num_rows($result_total) > 0) {
    while ($row = mysqli_fetch_assoc($result_total)) {

        ?>
        <div class="right-half">
        <div class="circle" align="center">
        <div class="counters">
        <div class="counter" data-target="<?php echo $row['total'] ?>"><p style=" margin: auto; width: 110px">0</p></div>
        </div>
        </div>
         <p><span style="font-weight: bold"> RESPONDENTS</span> <br> have answered the survey</p>
        </div>

    <?php
}
}
?>

	<!-- script for the count animation -->
    <script>
    const counters = document.querySelectorAll('.counter');
        const speed = 2; // The lower the slower

        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;

                // Lower inc to slow and higher to slow
                const inc_toRound = target / speed;
                const inc = Math.round(inc_toRound);

                // console.log(inc);
                // console.log(count);

                // Check if target is reached
                if (count < target) {
                    // Add inc to count and output in counter
                    counter.innerText = count + inc;
                    // Call function every ms
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target;
                }
            };

            updateCount();
    });
    </script>

    </div>

    <!-- script the demographics graph -->
    <script>
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                //get the count of respondents in json format from demographics_data, 
                //demographics_data.php is sensitive so no comments are allowed in the file
                $.post("demographics_data.php",
                function (data)
                {
                    console.log(data);
                     var degree = [];
                    var count = [];

                    for (var i in data) {
                        degree.push(data[i].degree_program);
                        count.push(data[i].count);
                    }

                    var chartdata = {
                        labels: degree,
                        datasets: [
                            {
                                borderRadius: 10,
                                barPercentage: 0.5,
                                label: 'Respondents',
                                backgroundColor: '#7CB342',
                                borderColor: '#FFFFFF',

                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: count
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata

                    });
                });
            }
        }
    </script>




    <?php
// check if the category is Rating
if ($class == "rating") {

    ?>

        <div align="center" width="100%" class="header">
            <h3>RATING</h3>
        </div>

        <!-- navigation bar for the tally -->
        <div align="center">
            <div class="pagination">
                <a href="">&laquo;</a>
                <a title="Rating" href="admin.php?class=<?php echo "rating" ?>">1</a>
                <a title="Suggestion/Opinion" href="admin.php?class=<?php echo "suggestion" ?>">2</a>
                <a title="Consent" href="admin.php?class=<?php echo "consent" ?>">3</a>
                <a href="admin.php?class=<?php echo "suggestion" ?>">&raquo;</a>
            </div>
        </div>




     <!-- table for the total tally -->
    <table width="100%" style="margin-top: 15px" cellspacing="0">
    <thead class="head">
    <tr>
        <th width="10px" style="background-color: white"></th>
        <th align="center" style="font-weight: bold; width: 50%; background-color: white">Questions</th>
        <th width="100%" style="background-color: white">
            <table style="font-size: 12px; font-weight: bold">
                <tr>
                    <td width="73px">Not Applicable</td>
                    <td width="96px">Needs Improvement</td>
                    <td width="37px">Poor</td>
                    <td width="86px">Satisfactory</td>
                    <td width="42px">Good</td>
                    <td width="64px">Excellent</td>

                </tr>
            </table>
        </th>
    </tr>
    </thead>



    <tr>
        <td></td>
        <td colspan="2" style="font-weight: bold; "><p style="margin: 20px 0px 0px 0px">Degree Program</p></td>
    </tr>

    <tbody>


    <?php

    //select the rateable questions from the database 
    $select1 = "SELECT question_id, question, rateable FROM questionnaire";
    $result1 = mysqli_query($conn, $select1);

    if (mysqli_num_rows($result1) > 0) {
        while ($row = mysqli_fetch_assoc($result1)) {
            if ($row['rateable'] == 'True' && $row['question_id'] <= 11) {

                $q_id = $row['question_id'];

                //count the number of respondents who answered the corresponding rate
                $count11        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '1'";
                $count_result11 = mysqli_query($conn, $count11);

                $count12        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '2'";
                $count_result12 = mysqli_query($conn, $count12);

                $count13        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '3'";
                $count_result13 = mysqli_query($conn, $count13);

                $count14        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '4'";
                $count_result14 = mysqli_query($conn, $count14);

                $count15        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '5'";
                $count_result15 = mysqli_query($conn, $count15);
                ?>

                <tr class="question">

                	<!-- button for in-depth view of the total tally per question, including the graph -->
                    <td><button class="btn" type="button" title="View Graph" onclick="location.href='rate.php?question_id=<?php echo $row['question_id'] ?>&class=<?php echo "Degree Program" ?>';" ><i class="fa fa-bars"></i></button></td>

                    <!-- print the question-->
                    <td style="width: 400px; border-bottom: 1px solid #e6e6e6; "><?php echo $row['question'] ?></td>
                    <td style="border-bottom: 1px solid #e6e6e6;">
                    <table width="100%">
                    <tr align="center">

<!-- print the score for each rating, then use the data to update the table rating_graph  -->
                        <td width="73">X</td>
                        <td width="96px">
<?php
if (mysqli_num_rows($count_result11) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result11)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET one = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>

                        <td width="37px">
            <?php
if (mysqli_num_rows($count_result12) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result12)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET two = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>

                        <td width="86px">
            <?php
if (mysqli_num_rows($count_result13) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result13)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET three = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>

                        <td width="42px">
                            <?php
if (mysqli_num_rows($count_result14) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result14)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET four = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>

                        <td width="64px">
                            <?php
if (mysqli_num_rows($count_result15) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result15)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET five = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>




                    </tr>
                    </table>
                    <td>
                </tr>

		<?php
}
        }
    }?>


    <tr>
        <td></td>
        <td colspan="2" style="font-weight: bold; width: 400px"><p style="margin: 20px 0px 0px 0px">Facilities and Infrastructure</p></td>
        <td>
        </td>
    </tr>


<?php

    $select2 = "SELECT question_id, question, rateable FROM questionnaire";
    $result2 = mysqli_query($conn, $select2);

    if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_assoc($result2)) {
            if ($row['rateable'] == 'True' && $row['question_id'] >= 12 && $row['question_id'] <= 15) {

                $q_id = $row['question_id'];

                $count21        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '1'";
                $count_result21 = mysqli_query($conn, $count21);

                $count22        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '2'";
                $count_result22 = mysqli_query($conn, $count22);

                $count23        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '3'";
                $count_result23 = mysqli_query($conn, $count23);

                $count24        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '4'";
                $count_result24 = mysqli_query($conn, $count24);

                $count25        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '5'";
                $count_result25 = mysqli_query($conn, $count25);

                ?>

                <tr class="question">
                    <td><button class="btn" type="button" title="View Graph" onclick="location.href='rate.php?question_id=<?php echo $row['question_id'] ?>&class=<?php echo "Facilities and Infrastructure" ?>'" ><i class="fa fa-bars"></i></button></td>
                    <td style="width: 400px; border-bottom: 1px solid #e6e6e6;"><?php echo $row['question'] ?></td>
                    <td style="border-bottom: 1px solid #e6e6e6;">
                    <table width="100%">
                    <tr align="center">
                        <td width="73">X</td>

                        <td width="96px">
                            <?php
if (mysqli_num_rows($count_result21) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result21)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET one = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>

                        <td width="37px">
                            <?php
if (mysqli_num_rows($count_result22) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result22)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET two = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>

                        <td width="86px">
                            <?php
if (mysqli_num_rows($count_result23) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result23)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET three = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>

                        <td width="42px">
                            <?php
if (mysqli_num_rows($count_result24) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result24)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET four = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>

                        <td width="64px">
                            <?php
if (mysqli_num_rows($count_result25) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result25)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET five = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>


                    </tr>
                    </table>
                    <td>
                </tr>

        <?php
}
        }
    }?>



    <tr>
        <td></td>
        <td colspan="2"><p style="margin: 20px 0px 0px 0px">How will you rate the following services provided by the following offices?</p></td>
    </tr>


<?php

    $select3 = "SELECT question_id, question, rateable FROM questionnaire";
    $result3 = mysqli_query($conn, $select3);

    if (mysqli_num_rows($result3) > 0) {
        while ($row = mysqli_fetch_assoc($result3)) {
            if ($row['rateable'] == 'True' && $row['question_id'] >= 16 && $row['question_id'] <= 28) {

                $q_id = $row['question_id'];

                $count30        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '0'";
                $count_result30 = mysqli_query($conn, $count30);

                $count31        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '1'";
                $count_result31 = mysqli_query($conn, $count31);

                $count32        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '2'";
                $count_result32 = mysqli_query($conn, $count32);

                $count33        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '3'";
                $count_result33 = mysqli_query($conn, $count33);

                $count34        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '4'";
                $count_result34 = mysqli_query($conn, $count34);

                $count35        = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '5'";
                $count_result35 = mysqli_query($conn, $count35);

                ?>

                <tr class="question">
                    <td><button class="btn" type="button" title="View Graph" onclick="location.href='rate.php?question_id=<?php echo $row['question_id'] ?>&class=<?php echo "Facilities and Infrastructure" ?>'" ><i class="fa fa-bars"></i></button></td>
                    <td style="width: 400px; border-bottom: 1px solid #e6e6e6;"><?php echo $row['question'] ?></td>
                    <td style="border-bottom: 1px solid #e6e6e6;">
                    <table width="100%">
                    <tr align="center">
                        <td width="73">
                            <?php
if (mysqli_num_rows($count_result30) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result30)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET zero = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>
                        </td>

                        <td width="96px">
                            <?php
if (mysqli_num_rows($count_result31) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result31)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET one = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>

                        <td width="37px">
                            <?php
if (mysqli_num_rows($count_result32) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result32)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET two = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>

                        <td width="86px">
                            <?php
if (mysqli_num_rows($count_result33) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result33)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET three = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>

                        <td width="42px">
                            <?php
if (mysqli_num_rows($count_result34) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result34)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET four = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>

                        <td width="64px">
                            <?php
if (mysqli_num_rows($count_result35) > 0) {
                    while ($row = mysqli_fetch_assoc($count_result35)) {
                        echo $row['score'];

                        $score  = $row['score'];
                        $update = "UPDATE rating_graph SET five = '$score' WHERE question_id = '$q_id'";

                        if ($conn->query($update) && false) {
                            echo "Error: " . $update . "<br>" . $conn->error . "<br><br>";
                        }

                    }
                }
                ?>

                        </td>


                    </tr>
                    </table>
                    <td>
                </tr>

        <?php
}
        }
    }
    ?>
            </tbody>
        </table>
    <?php
}?>





<!-- check if the category is Suggestion/Opinion-->
    <?php
if ($class == "suggestion") {

    ?>

        <div align="center" width="100%" class="header">
            <h3>SUGGESTION/OPINION</h3>
        </div>

    <!-- navigation bar for the tally -->
    <div align="center">
            <div class="pagination">
                <a href="admin.php?class=<?php echo "rating" ?>">&laquo;</a>
                <a title="Rating" href="admin.php?class=<?php echo "rating" ?>">1</a>
                <a title="Suggestion/Opinion" href="admin.php?class=<?php echo "suggestion" ?>">2</a>
                <a title="Consent" href="admin.php?class=<?php echo "consent" ?>">3</a>
                <a href="admin.php?class=<?php echo "consent" ?>">&raquo;</a>
            </div>
    </div>

    <table width="100%" style="margin-top: 15px">
    <tr>
        <td style="font-weight: bold; ">Degree Program</td>
    </tr>
    </table>

    <?php
    //show the unrateable questions from the database
$select4 = "SELECT question_id, question, rateable FROM questionnaire";
    $result4 = mysqli_query($conn, $select4);

    if (mysqli_num_rows($result4) > 0) {
        while ($row = mysqli_fetch_assoc($result4)) {
            if ($row['rateable'] == 'False' && $row['question_id'] <= 11) {

                $q_id = $row['question_id'];

                //show the answers from each of the questions
                $answer4 = "SELECT demographics.full_name, demographics.up_mail, suggestion.comments
                    FROM demographics NATURAL JOIN suggestion
                    WHERE (demographics.id = suggestion.id) AND suggestion.question_id ='$q_id'";
                $answer_result4 = mysqli_query($conn, $answer4);

                ?>

        <table width="100%">
            <tr>
            	<!-- print the question -->
                <td><?php echo $row['question'] ?></td>
            </tr>
            <tr>

            	<!-- show the answers in list form -->
                <td style="padding: 10px">
                    <div class="list">
                        <ul>
                        <?php

                $i = 1;
                if (mysqli_num_rows($answer_result4) > 0) {
                    while ($row = mysqli_fetch_assoc($answer_result4)) {
                        ?>
                        <li>
                            <table class="border-bot" width="100%">
                                <tr>
                                    <td valign="top" style="width: 200px">
                                        <?php
echo $i . ". ";

                        if ($row['full_name'] == null) {
                            echo $row['up_mail'];
                        } else {
                            echo $row['full_name'];}
                        ?>
                                    </td>
                                    <td><?php echo $row['comments'] ?></td>
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
    <?php
}
        }
    }
    ?>

    <table width="100%" style="margin-top: 15px">
    <tr>
        <td style="font-weight: bold; ">Facilities and Infrastructure</td>
    </tr>
    </table>

     <?php
$select4 = "SELECT question_id, question, rateable FROM questionnaire";
    $result4 = mysqli_query($conn, $select4);

    if (mysqli_num_rows($result4) > 0) {
        while ($row = mysqli_fetch_assoc($result4)) {
            if ($row['rateable'] == 'False' && $row['question_id'] == 15) {

                $q_id = $row['question_id'];

                $answer5 = "SELECT demographics.full_name, demographics.up_mail, suggestion.comments
                    FROM demographics NATURAL JOIN suggestion
                    WHERE (demographics.id = suggestion.id) AND suggestion.question_id ='$q_id'";
                $answer_result5 = mysqli_query($conn, $answer5);

                ?>

        <table cellspacing="0" width="100%">
            <tr class="question">
                <td><button class="btn" title="View Graph" type="button" onclick="location.href='event1.php?question_id=15&class=<?php echo "suggestion" ?>';" ><i class="fa fa-bars"></i></button></td>
                <td><?php echo $row['question'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 10px">
                    <div class="list">
                    <ul>
                        <?php

                $i = 1;

                if (mysqli_num_rows($answer_result5) > 0) {
                    while ($row = mysqli_fetch_assoc($answer_result5)) {
                        ?>
                        <li>
                            <table class="border-bot" width="100%">
                                <tr>
                                    <td valign="top" style="width: 200px">
                                        <?php
echo $i . ". ";
                        if ($row['full_name'] == null) {
                            echo $row['up_mail'];
                        } else {
                            echo $row['full_name'];}
                        ?>
                                    </td>
                                    <td><?php echo $row['comments'] ?></td>
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
    <?php
}
        }
    }
    ?>

    <table cellspacing="0" width="100%" style="margin-top: 15px">
    <tr>
        <td style="font-weight: bold; ">Financial Aid</td>
    </tr>
    </table>

     <?php

    $select4 = "SELECT question_id, question, rateable FROM questionnaire";
    $result4 = mysqli_query($conn, $select4);

    if (mysqli_num_rows($result4) > 0) {
        while ($row = mysqli_fetch_assoc($result4)) {
            if ($row['rateable'] == 'False' && $row['question_id'] >= 29 && $row['question_id'] <= 30) {

                $q_id = $row['question_id'];

                //show the polar questions
                $answer6 = "SELECT demographics.full_name, demographics.up_mail, polar.answers
                    FROM demographics NATURAL JOIN polar
                    WHERE (demographics.id = polar.id) AND polar.question_id ='$q_id'";
                $answer_result6 = mysqli_query($conn, $answer6);

                //count the answers for the percentage
                $total        = "SELECT COUNT(answers) as total FROM polar WHERE question_id = '$q_id'";
                $result_total = mysqli_query($conn, $total);

                if (mysqli_num_rows($result_total) > 0) {
                    while ($rowt = mysqli_fetch_assoc($result_total)) {
                        $total_val = $rowt['total'];

                        ?>

        <table cellspacing="0" width="100%">
            <tr class="question">
                <td width="80%"><?php echo $row['question'] ?></td>
                <td align="center">
                <?php

//get the count of respondents who answered "yes" and compute for the percentage
$count_yes1  = "SELECT COUNT(answers) as yes FROM polar WHERE question_id = '$q_id' AND answers = 'yes'";
                        $result_yes1 = mysqli_query($conn, $count_yes1);

                        if (mysqli_num_rows($result_yes1) > 0) {
                            while ($row = mysqli_fetch_assoc($result_yes1)) {
                                $value = round(($row['yes'] / $total_val) * 100);
                                echo "Yes: " . $value . "%";
                            }
                        }
                        ?>
                </td>
                <td align="center">
                <?php
//get the count of respondents who answered "yes" and compute for the percentage
$count_no1  = "SELECT COUNT(answers) as no FROM polar WHERE question_id = '$q_id' AND answers = 'no'";
                        $result_no1 = mysqli_query($conn, $count_no1);

                        if (mysqli_num_rows($result_no1) > 0) {
                            while ($row = mysqli_fetch_assoc($result_no1)) {
                                $value = round(($row['no'] / $total_val) * 100);
                                echo "No: " . $value . "%";
                            }
                        }
                        ?>

                </td>
            <tr>
                <td style="padding: 10px">
                    <div class="list">
                    <ul>
                        <?php
						$i = 1;

                        if (mysqli_num_rows($answer_result6) > 0) {
                            while ($row = mysqli_fetch_assoc($answer_result6)) {
                                ?>
                        <li>
                            <table class="border-bot" width="100%">
                                <tr>
                                    <td valign="top" style="width: 200px">
                                        <?php
								echo $i . ". ";
                                if ($row['full_name'] == null) {
                                    echo $row['up_mail'];
                                } else {
                                    echo $row['full_name'];}
                                ?>
                                    </td>
                                    <td><?php echo $row['answers'] ?></td>
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
    <?php
}
                }
            }
        }
    }
    ?>

    <table width="100%" style="margin-top: 15px">
    <tr>
        <td style="font-weight: bold; ">Events</td>
    </tr>
    </table>

     <?php

    $select4 = "SELECT question_id, question, rateable FROM questionnaire";
    $result4 = mysqli_query($conn, $select4);

    if (mysqli_num_rows($result4) > 0) {
        while ($row = mysqli_fetch_assoc($result4)) {
            if ($row['rateable'] == 'False' && $row['question_id'] >= 31 && $row['question_id'] <= 33) {

                $q_id = $row['question_id'];

                $answer7 = "SELECT demographics.full_name, demographics.up_mail, suggestion.comments
                    FROM demographics NATURAL JOIN suggestion
                    WHERE (demographics.id = suggestion.id) AND suggestion.question_id ='$q_id'";
                $answer_result7 = mysqli_query($conn, $answer7);

                ?>

        <table cellspacing="0" width="100%">
            <tr  class="question">

                    <?php if ($row['question_id'] == 31) {
                    ?>
                         <td width="35px"><button class="btn" title="View Graph" type="button" onclick="location.href='event2.php?question_id=31&class=<?php echo "suggestion" ?>';" ><i class="fa fa-bars"></i></button></td>
                    <?php
} elseif ($row['question_id'] == 32) {
                    ?>

                        <td width="35px"><button class="btn" type="button" onclick="location.href='event3.php?question_id=32&class=<?php echo "suggestion" ?>';" ><i class="fa fa-bars"></i></button></td>

                    <?php
				}
                ?>



                <td><?php echo $row['question'] ?></td>
            <tr>
                <td colspan="2" style="padding: 10px">
                    <div class="list">
                    <ul>
                        <?php
				$i = 1;
                if (mysqli_num_rows($answer_result7) > 0) {
                    while ($row = mysqli_fetch_assoc($answer_result7)) {
                        ?>
                        <li>
                            <table class="border-bot" width="100%">
                                <tr>
                                    <td valign="top" style="width: 200px">
                                        <?php
						echo $i . ". ";
                        if ($row['full_name'] == null) {
                            echo $row['up_mail'];
                        } else {
                            echo $row['full_name'];}
                        ?>
                                    </td>
                                    <td><?php echo $row['comments'] ?></td>
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
    <?php
}
        }
    }
    ?>

    <table width="100%" style="margin-top: 15px">
    <tr>
        <td style="font-weight: bold; ">Career Plans</td>
    </tr>
    </table>

     <?php

    $select4 = "SELECT question_id, question, rateable FROM questionnaire";
    $result4 = mysqli_query($conn, $select4);

    if (mysqli_num_rows($result4) > 0) {
        while ($row = mysqli_fetch_assoc($result4)) {
            if ($row['rateable'] == 'False' && $row['question_id'] == 34) {

                $q_id = $row['question_id'];

                $answer8 = "SELECT demographics.full_name, demographics.up_mail, suggestion.comments
                    FROM demographics NATURAL JOIN suggestion
                    WHERE (demographics.id = suggestion.id) AND suggestion.question_id ='$q_id'";
                $answer_result8 = mysqli_query($conn, $answer8);

                ?>

        <table cellspacing="0" width="100%">
            <tr class="question">
                <td  width="35px"><button class="btn" title="View Graph" type="button" onclick="location.href='event4.php?question_id=34&class=<?php echo "suggestion" ?>';" ><i class="fa fa-bars"></i></button></td>
                <td><?php echo $row['question'] ?></td>
            <tr>
                <td colspan="2" style="padding: 10px;">
                    <div class="list">
                    <ul>
                        <?php
				$i = 1;
                if (mysqli_num_rows($answer_result8) > 0) {
                    while ($row = mysqli_fetch_assoc($answer_result8)) {
                        ?>
                        <li>
                            <table class="border-bot" width="100%">
                                <tr>
                                    <td valign="top" style="width: 200px">
                                        <?php
						echo $i . ". ";
                        if ($row['full_name'] == null) {
                            echo $row['up_mail'];
                        } else {
                            echo $row['full_name'];}
                        ?>
                                    </td>
                                    <td><?php echo $row['comments'] ?></td>
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
    <?php
} elseif ($row['rateable'] == 'False' && $row['question_id'] == 35) {

                $q_id = $row['question_id'];

                $answer9 = "SELECT demographics.full_name, demographics.up_mail, polar.answers
                    FROM demographics NATURAL JOIN polar
                    WHERE (demographics.id = polar.id) AND polar.question_id ='$q_id'";
                $answer_result9 = mysqli_query($conn, $answer9);

                $total        = "SELECT COUNT(answers) as total FROM polar WHERE question_id = '$q_id'";
                $result_total = mysqli_query($conn, $total);

                if (mysqli_num_rows($result_total) > 0) {
                    while ($rowt = mysqli_fetch_assoc($result_total)) {
                        $total_val = $rowt['total'];
                        ?>

            <table cellspacing="0" width="100%">
            <tr  class="question">
                <td width="80%"><?php echo $row['question'] ?></td>
                <td align="center">
                <?php
$count_yes1  = "SELECT COUNT(answers) as yes FROM polar WHERE question_id = '$q_id' AND answers = 'yes'";
                        $result_yes1 = mysqli_query($conn, $count_yes1);

                        if (mysqli_num_rows($result_yes1) > 0) {
                            while ($row = mysqli_fetch_assoc($result_yes1)) {
                                $value = round(($row['yes'] / $total_val) * 100);
                                echo "Yes: " . $value . "%";
                            }
                        }
                        ?>
                </td>
                <td align="center">
                <?php
$count_no1  = "SELECT COUNT(answers) as no FROM polar WHERE question_id = '$q_id' AND answers = 'no'";
                        $result_no1 = mysqli_query($conn, $count_no1);

                        if (mysqli_num_rows($result_no1) > 0) {
                            while ($row = mysqli_fetch_assoc($result_no1)) {
                                $value = round(($row['no'] / $total_val) * 100);
                                echo "No: " . $value . "%";
                            }
                        }
                        ?>

                </td>
            <tr>
                <td style="padding: 10px">
                    <div class="list">
                    <ul>
                        <?php
$i = 1;
                        if (mysqli_num_rows($answer_result9) > 0) {
                            while ($row = mysqli_fetch_assoc($answer_result9)) {
                                ?>
                        <li>
                            <table class="border-bot" width="100%">
                                <tr>
                                    <td valign="top" style="width: 200px">
                                        <?php
echo $i . ". ";
                                if ($row['full_name'] == null) {
                                    echo $row['up_mail'];
                                } else {
                                    echo $row['full_name'];}
                                ?>
                                    </td>
                                    <td><?php echo $row['answers'] ?></td>
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

            <?php

                    }
                }
            }
        }
    }
    ?>

    <table width="100%" style="margin-top: 15px">
    <tr>
        <td style="font-weight: bold; ">Other Comments and Suggestions</td>
    </tr>
    </table>

     <?php

    $select4 = "SELECT question_id, question, rateable FROM questionnaire";
    $result4 = mysqli_query($conn, $select4);

    if (mysqli_num_rows($result4) > 0) {
        while ($row = mysqli_fetch_assoc($result4)) {
            if ($row['rateable'] == 'False' && $row['question_id'] == 37) {

                $q_id = $row['question_id'];

                $answer8 = "SELECT demographics.full_name, demographics.up_mail, suggestion.comments
                    FROM demographics NATURAL JOIN suggestion
                    WHERE (demographics.id = suggestion.id) AND suggestion.question_id ='$q_id'";
                $answer_result8 = mysqli_query($conn, $answer8);

                ?>

        <table width="100%">
            <tr>
                <td style="padding: 10px">
                    <div class="list">
                    <ul>
                        <?php
$i = 1;
                if (mysqli_num_rows($answer_result8) > 0) {
                    while ($row = mysqli_fetch_assoc($answer_result8)) {
                        ?>
                        <li>
                            <table class="border-bot" width="100%">
                                <tr>
                                    <td valign="top"  style="width: 200px">
                                        <?php
echo $i . ". ";
                        if ($row['full_name'] == null) {
                            echo $row['up_mail'];
                        } else {
                            echo $row['full_name'];}
                        ?>
                                    </td>
                                    <td><?php echo $row['comments'] ?></td>
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
    <?php
}
        }
    }
    ?>

    <?php
}?>

    <?php
//check if the category is Consent
if ($class == "consent") {

    ?>

            <div align="center" width="100%" class="header">
            <h3>CONSENT</h3>
        </div>

     <div align="center">
            <div class="pagination">
                <a href="admin.php?class=<?php echo "suggestion" ?>">&laquo;</a>
                <a title="Rating" href="admin.php?class=<?php echo "rating" ?>">1</a>
                <a title="Suggestion/Opinion" href="admin.php?class=<?php echo "suggestion" ?>">2</a>
                <a title="Consent" href="admin.php?class=<?php echo "consent" ?>">3</a>
                <a href="">&raquo;</a>
            </div>
    </div>

    <table width="100%" style="margin-top: 15px">
    <tr>
        <td style="font-weight: bold; ">Consent for a Follow-up Interview</td>
    </tr>
    </table>

     <?php

    //show the the question for the consent
    $select4 = "SELECT question_id, question, rateable FROM questionnaire";
    $result4 = mysqli_query($conn, $select4);

    if (mysqli_num_rows($result4) > 0) {
        while ($row = mysqli_fetch_assoc($result4)) {
            if ($row['rateable'] == 'False' && $row['question_id'] == 36) {

                $q_id = $row['question_id'];

                //get the answers from the consent table
                $answer9 = "SELECT demographics.full_name, demographics.up_mail, consent.answers
                    FROM demographics NATURAL JOIN consent
                    WHERE (demographics.id = consent.id) AND consent.question_id ='$q_id'";
                $answer_result9 = mysqli_query($conn, $answer9);

                ?>

        <table width="100%">
            <tr class="question">
                <td ><?php echo $row['question'] ?></td>
            <tr>
            <tr>
                <td style="padding: 10px">
                	<!-- print the answers in list form -->
                    <div class="list">
                    <ul>
                        <?php
if (mysqli_num_rows($answer_result9) > 0) {
                    while ($row = mysqli_fetch_assoc($answer_result9)) {
                        ?>
                        <li>
                            <table width="100%">
                                <tr>
                                    <td style="width: 200px">
                                        <?php
if ($row['full_name'] == null) {
                            echo $row['up_mail'];
                        } else {
                            echo $row['full_name'];}
                        ?>
                                    </td>
                                    <td><?php echo $row['answers'] ?></td>
                                </tr>
                            </table>
                            </li>

                        <?php
}
                }
                ?>
                    </ul>
                    </div>
                </td>
            </tr>
        </table>
    <?php
}
        }
    }
    ?>




     <?php
}
//close the connection
mysqli_close($conn);?>

        </div>
        </div>

    </div>
    </div>
    </div>

</body>
</html>
