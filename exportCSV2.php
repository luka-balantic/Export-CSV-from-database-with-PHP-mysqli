<?php
$host      = "localhost";
$user      = "root";
$pass      = "";
$db_name   = "maindb";
$exp_table = "kcdb_hardware_inventory"; // Table to export

$mysqli = new mysqli($host, $user, $pass, $db_name);
$mysqli->set_charset("utf8");

if (!$mysqli)
    die("ERROR: Could not connect. " . mysqli_connect_error());

// Create and open new csv file
$csv  = $exp_table . "-" . date('d-m-Y-his') . '.csv';
$file = fopen($csv, 'w');

// Get the table
if (!$mysqli_result = mysqli_query($mysqli, "SELECT * FROM {$exp_table}"))
    printf("Error: %s\n", $mysqli->error);

    // Get column names 
    while ($column = mysqli_fetch_field($mysqli_result)) {
        $column_names[] = $column->name;
    }
    
    // Write column names in csv file
    if (!fputcsv($file, $column_names))
        die('Can\'t write column names in csv file');
    
    // Get table rows
    while ($row = mysqli_fetch_row($mysqli_result)) {
        // Write table rows in csv files
        if (!fputcsv($file, $row))
            die('Can\'t write rows in csv file');
    }

fclose($file);

echo "<p><a href=\"$csv\">Download</a></p>\n"; 