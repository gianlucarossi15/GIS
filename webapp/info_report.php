
<!DOCTYPE html>
<html>  
    <head>
        <meta charset="UTF-8">
        <?php 
            
            session_start();
            if(!isset($_SESSION["username"]) || !isset($_SESSION["password"])){
                header("Location:login.php");
                exit;
            }
            include("include.html");
            include("navbar.php");
            // we extract the id of the report
            $id=explode('=',explode('?',$_SERVER["REQUEST_URI"])[1])[1];

            require_once("conn.php");
            $query="SELECT report_date, hole_type, description, photo_path, ST_AsText (coordinate) as coor FROM public.report WHERE id_report=$1";
            $res = pg_prepare($conn, "query", $query);
            $res=pg_execute($conn,"query",array($id));

            $row = pg_fetch_assoc($res);
            $date;
            $hole_type;
            $photo_name;
            $photo_path;
            if ($row) {
                $date=$row["report_date"];
                $hole_type=$row["hole_type"];
            
                if($row["photo_path"]!=NULL)
                    $photo_path=$row["photo_path"];
                else
                    $photo_path="images/no-image.png";
                $coordinate = $row['coor'];
                $description=$row['description'];
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
    </head>
    <body>
        <div id="map" class="map"></div>
        <h2 class="text-center title">Report number <?php echo $id;?> of the  <?php echo $date;?></h2>
        <table class="table"> 
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Report Date</th>
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                    <th scope="col">Type of hole</th>
                </tr>
            </thead>
            <tbody>
                <tr scope="row">
                    <th> <?php echo $id;?></th>
                    <td> <?php echo $date;?></td>
                    <td><img src="<?php echo $photo_path;?>" width="200"></td>
                    <td><?php echo $description;?></td>
                    <td><?php echo $hole_type;?></td>
                </tr>
            </tbody>
        </table>
       
        
        
        <span></span>
    </body>
    <footer>
        <?php
            include("footer.php"); 
        ?>
        <script src="js/report.js"></script>
        
    </footer>
    </footer>
</html>
