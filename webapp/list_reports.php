<?php
    session_start();
    if(!isset($_SESSION["username"]) || !isset($_SESSION["password"])){
        header("Location:login.php");
        exit;
    }
    include("include.html");
    include("navbar.php");
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <form action="list_reports.php" method="POST">
            <div class="">    
                <div class="text-center">
                    <label for="id_year" class="mb-5"><h4>Select year</h4></label>
                    <select id="id_year" name="year" class="form-select form-control-sm" onchange="this.form.submit();">
                </div>
            </div>
            <?php
                require_once("conn.php");
                $year;
                if(isset($_POST["year"]))
                    $year=$_POST["year"];
                $query="SELECT DISTINCT EXTRACT(year from report_date) as year FROM report ORDER BY year DESC;";
                $result = pg_query($conn, $query);
                while ($row = pg_fetch_array($result)) {
                    if(isset($year) && $year==$row[0])
                        // if a specific year is selected in the drop-down menu, we extract the reports of that year
                        echo "<option value=$row[0] selected>$row[0]</option>";
                    else if(!isset($year) && date('Y')==$row[0])
                        echo "<option value= $row[0] selected>$row[0]</option>";
                    else
                        echo "<option value= $row[0] >$row[0]</option>";
                }
            ?>
            </select>
        </form>
            <?php
                $query;
                $res;
                if(isset($_POST['year'])){
                    $year=$_POST['year'];
                     //we extract the reports of the selected year
                    $query="SELECT * FROM public.report WHERE extract(year from report_date) = $1  ORDER BY report_date";
                    $res = pg_prepare($conn, "query", $query);
                }else{
                    $year=date('Y');
                    //we extract the reports of the current year
                    $query="SELECT * FROM public.report WHERE extract(year from report_date) = $1 ORDER BY report_date";
                    $res = pg_prepare($conn, "query", $query);
                   
                }
                $res=pg_execute($conn,"query",array($year));

                echo "<table class='table'>";
                echo "<thead class='thead-light'> <tr> <th scope='col'>#</th> <th scope='col'>Report Date</th> <th scope='col'>Type of hole</th> <th scope='col'>Description</th> <th scope='col'>Photo</th> <th scope='col'>Details</th></tr></thead><tbody>";
                while($row=pg_fetch_assoc($res)){
                    $id=$row['id_report'];
                    $date=$row['report_date'];
                    $hole_type=$row['hole_type'];
                    $desc=$row['description'];
                    $photo=$row['photo_name'];
                    if($photo !=NULL)
                        $photo="present";
                    else    
                        $photo="not present";
                    $url="info_report.php?id=$id";
                    echo "<tr> <th scope='row'>$id</th> <td>$date</td>  <td>$hole_type</td> <td>$desc</td> <td>$photo</td> <td><a href=$url><button type='button' class='btn btn-primary'>Details</button></a></td></tr>";
                }
                echo "</tbody></table>";
                
                $url="info_reports.php?year=$year";
                echo "<div class='text-right'>";
                echo "<a href=$url><button type='button' class='link btn btn-secondary'>View all reports</button></a></div>";
             
                
            ?>
            
    </body>
    <footer>
        <?php
            include("footer.php"); 
        ?>
    </footer>
</html>