<?php
    session_start();
    if(!isset($_SESSION["username"]) || !isset($_SESSION["password"])){
        header("Location:login.php");
        exit;
    }
    include("include.html");
    include("navbar.php");
    $query;
    $res;
    $year=explode('=',explode('?',$_SERVER["REQUEST_URI"])[1])[1];

    echo $year;
    require_once("conn.php");
    $query="SELECT id_report, report_date, hole_type, description, photo_path, ST_AsText (coordinate) as coor FROM public.report WHERE extract(year from report_date) = $1";

    $res = pg_prepare($conn, "query", $query);
    $res=pg_execute($conn,"query",array($year));
    $lat_arr=array();
    $long_arr=array();
    $hole_arr=array();
    $photo_arr=array();
    $id_arr=array();
    $i=0;
    
    while($row=pg_fetch_assoc($res)){
        
        //echo $row['id_report']."<br/>";
        $id_arr[$i]=$row['id_report'];
        $coordinate = $row['coor'];
        $coor = substr($coordinate, 6);
        $coordinate = explode(" ", substr($coor, 0, strlen($coor)-1));
        $long_arr[$i]=$coordinate[0];
        $lat_arr[$i]=$coordinate[1];
        $hole_arr[$i]=$row['hole_type'];
        if($row['photo_path']!=NULL)
            $photo_arr[$i]="yes";
        else   
            $photo_arr[$i]="no";
        
        
        $i++;
    }
    $lat_csv = implode(",", $lat_arr);
    $long_csv = implode(",", $long_arr);
    $hole_csv = implode(",", $hole_arr);
    $photo_csv = implode(",", $photo_arr);
    
    $id_csv = implode(",", $id_arr);

    // console.log($id_csv);
    
    echo "<input type='hidden' id='id' value=$id_csv>";
    echo "<input type='hidden' id='longitude' value=$long_csv>";
    echo "<input type='hidden' id='latitude' value=$lat_csv>";
    echo "<input type='hidden' id='hole' value=$hole_csv>";
    echo "<input type='hidden' id='photo' value=$photo_csv>";
    
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <div id="map" class="map"></div>
        <div id="popup" class=" ol-popup">
            <span id="popup-closer" class="ol-popup-closer"></span>
            <div id="popup-content" name="popup-content"></div>
        </div>
        <br/>
        <!-- <table class="table">
        <thead class="thead-light"> <tr> <th scope="col">#</th> <th scope="col">Report Date</th> <th scope="col">Type of hole</th> <th scope="col">Description</th> <th scope="col">Photo</th> <th scope="col">Details</th></tr></thead>
        <tbody><tr> <th scope='row'>$id</th> <td>$date</td>  <td>$hole_type</td> <td>$desc</td> <td>$photo</td> <td><a href=$url><button type='button' class='btn btn-primary'>Details</button></a></td></tr></tbody>
        </table> -->
    </body>
    <footer>
        <?php
            include("footer.php"); 
        ?>
        <script src="js/all_reports.js"></script>
            
    </footer>
</html>