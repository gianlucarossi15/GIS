<?php
    session_start();
    if(!isset($_SESSION["username"]) || !isset($_SESSION["password"])){
        header("Location:login.php");
        exit;
    }
    // we extract the id of the report
    $id=explode('=',explode('?',$_SERVER["REQUEST_URI"])[1])[1];

    require_once("conn.php");
    $query="SELECT ST_AsText (coordinate) as coor FROM public.report WHERE id_report=$id";
    $res=pg_query($conn,$query);

    $row = pg_fetch_assoc($res);
    if ($row) {
        $coordinate = $row['coor'];
        //echo $coordinate;
        $wft = substr($coordinate, 6);
        $coordinate = explode(" ", substr($wft, 0, strlen($wft)-1));
        $longitude=$coordinate[0];
        $latitude=$coordinate[1];
        echo "<input type='hidden' id='longitude' value=$longitude>";
        echo "<input type='hidden' id='latitude' value=$latitude>";
    
    } else {
        echo "No results found.";
    }

?>
<!DOCTYPE html>
<html>  
    <head>
        <meta charset="UTF-8">
        <?php include("include.html"); ?>
    </head>
    <body>
        <div id="map" class="map"></div>
    </body>
    <footer>
            <script src="js/report.js"></script>
    </footer>
</html>
