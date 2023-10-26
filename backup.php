<!-- function for backing up the sql database -->
<?php

//show an error message if access directly
define('MyConst', true);

//connect to database
include_once 'connection.php';

//filter accesses on this file
session_start();
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

if ($_SESSION['gatekeep1'] != false) {
    exit('Direct access denied!');
}

// database configuration
$host          = "localhost";
$username      = "root";
$password      = "";
$database_name = "exit_survey";

// Get connection object and set the charset
$conn->set_charset("utf8");

// Get All Table Names From the Database
$tables = array();
$sql    = "SHOW TABLES";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

$sqlScript = "";
foreach ($tables as $table) {

    // Prepare SQLscript for creating table structure
    $query  = "SHOW CREATE TABLE $table";
    $result = mysqli_query($conn, $query);
    $row    = mysqli_fetch_row($result);

    $sqlScript .= "\n\n" . $row[1] . ";\n\n";

    $query  = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);

    $columnCount = mysqli_num_fields($result);

    // Prepare SQLscript for dumping data for each table
    for ($i = 0; $i < $columnCount; $i++) {
        while ($row = mysqli_fetch_row($result)) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j++) {
                $row[$j] = $row[$j];

                if (isset($row[$j])) {
                    $sqlScript .= '"' . $row[$j] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }

    $sqlScript .= "\n";
}

if (!empty($sqlScript)) {
    // Save the SQL script to a backup file
    $backup_file_name = $database_name . '_backup_' . time() . '.sql';
    $fileHandler      = fopen($backup_file_name, 'w+');
    $number_of_lines  = fwrite($fileHandler, $sqlScript);
    fclose($fileHandler);

    // Download the SQL backup file to the browser
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backup_file_name));
    ob_clean();
    flush();
    readfile($backup_file_name);
    exec('rm ' . $backup_file_name);
}
