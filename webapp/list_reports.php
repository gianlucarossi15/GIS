<?php
    session_start();
    if(!isset($_SESSION["username"]) || !isset($_SESSION["password"])){
        header("Location:login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <form action="list_reports.php" method="POST">
            <label for="id_year">Select year</label>
            <select id="id_year" name="year" class="w-50" onchange="this.form.submit();">
                <option value="" hidden></option>
            <?php
              
                require_once("conn.php");
                $year=$_POST["year"];
                $query="SELECT DISTINCT EXTRACT(year from report_date) as year FROM report ORDER BY year DESC;";
                $result = pg_query($conn, $query);
                while ($row = pg_fetch_array($result)) {
                    if(isset($year) &&  $year== $row[0])
                        // if a specific year is selected in the drop-down menu, we extract the reports of that year
                        echo "<option value=$row[0] selected>$row[0]</option>";
                    else
                        echo "<option value= $row[0]>$row[0]</option>";
                }
            ?>
            </select>
        </form>
            <?php
                $query;
                $year=$_POST['year'];
                if(isset($year))
                    //we extract the reports of the selected year
                    $query="SELECT * FROM public.report WHERE extract(year from report_date) = $year  ORDER BY report_date";
                else
                    //we extract the reports of the current year
                    $query="SELECT * FROM public.report WHERE extract(year from report_date) = date('Y') ORDER BY report_date";
                $res=pg_query($conn,$query);

                echo "<table>";
                echo "<tr> <th>#</th> <th>Report Date</th> <th>Type of hole</th> <th>Description</th> <th>Photo</th> <th>Details</th></tr>";
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
                    echo "<tr> <td>$id</td> <td>$date</td>  <td>$hole_type</td> <td>$desc</td> <td>$photo</td> <td><a href=$url><button type='button' class='btn-secondary'>Details</button></a></td></tr>";
                }
                echo "</table>";
            ?>
    </body>
</html>