<?php

//utility for preventing direct access to php files
if (!defined('MyConst')) {
    ?>
	<h1>
		<?php
exit('Direct access not permitted');
    ?>
	</h1>

<?php
}

//database configuration
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "exit_survey";

//get the connection object
$conn = mysqli_connect($servername, $username, $password, $dbname);

//end the connection if error
if (!$conn) {
    die(mysqli_error($conn));
}

?>