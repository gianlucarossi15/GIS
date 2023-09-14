<?php

    // $servername = "localhost";
    // $dbname="gis";
    // $username = "postgres";
    // $password = "rossi";

    // Create connection
    $conn = pg_connect("host=localhost port=5432 dbname=gis user=postgres password=rossi");



    // Check connection
    if(!$conn)
        die("Error : Unable to establish connection with the database\n");
    
?>