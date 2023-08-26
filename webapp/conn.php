<?php
    $servername = "localhost";
    $user = "postgres";
    $psw = "rossi";
    $dbname="gis";

    // Create connection
    $conn = pg_connect("host=".$servername." port=5432 dbname=".$dbname." user=".$user." password=".$psw);

    // Check connection
    if(!$connection)
        echo "Error : Unable to establish connection with the database\n";
    echo "Connected successfully";
?>