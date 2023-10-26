<?php
include_once('connection.php');

            
            


?>


<?php

$conn->query('SET foreign_key_checks = 0');
if ($result = $conn->query("SHOW TABLES"))
{
    while($row = $result->fetch_array(MYSQLI_NUM))
    {
        $conn->query('DROP TABLE IF EXISTS '.$row[0]);
        echo $row[0].",\n";
    }
}

$conn->query('SET foreign_key_checks = 1');

$sql = '';
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
            
            if (substr(trim($line), - 1, 1) == ';') {
                $result = mysqli_query($conn, $sql);
                if (! $result) {
                    $error .= mysqli_error($conn) . "\n";
                }
                $sql = '';
            }
        } // end foreach
        
        if ($error) {
            $response = array(
                "type" => "error",
                "message" => $error
            );
        } else {
            $response = array(
                "type" => "success",
                "message" => "Database Restore Completed Successfully."
            );
        }
    } // end if file exists
    return $response;

    header("location: admin.php?class=rating");

?>

