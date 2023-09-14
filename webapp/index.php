<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <?php include("include.html"); ?>
        <!--custom css file-->
        <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>
        <h1 class="text-center title">Roads management for the City of Padova</h1>
        <?php
            session_start();
            if(isset($_SESSION["username"]) && isset($_SESSION["password"])){
                $user=$_SESSION["username"];
                echo "<span> You are logged in as: $user</span>";
            }
            else 
                echo "<a href='login.php'>LOGIN</a>";
        ?>
    
       
        <a href="logout.php">LOGOUT</a>
        <div id="map" class="map"></div>
        <br>
        <h2 class="text-center title">Submit a new report</h2>
        <div class="col-lg-5 col-md-6 col-sm-9 col-xs-11">
            <form action="insert_report.php" method="POST" id="hole_report" enctype="multipart/form-data">
                
                <div id="popup" class="ol-popup">
                    <span id="popup-closer" class="ol-popup-closer"></span>
                    <div id="popup-content" name="popup-content"></div> 
                  </div>
                <div class="row">
                    <div class="col">
                        <label for="dscrpt" >Insert a description</label>
                        <input type="text" id="dscrpt" name="description" placeholder="Description here" class="form-control">
                    </div>
                    <div class="col">
                        <label for="h_t">Type of hole</label> <br>
                        <select class="form-select" name="hole_type" id="h_t" required>
                            <option value="" hidden></option>
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                        </select>
                    </div>
                </div>
                <input type="file" name="hole_image" id="h_i" accept="image/jpg, image/png, image/jpeg, image/svg">
                
                <!--used to get the coordinate to the DB-->
                <input type="hidden"  name="latitude" id="latitude" value="" required/>
                <input type="hidden" name="longitude" id="longitude" value="" required/>


                <input type="submit" class="btn btn-danger" name="submit" />
                <input type="reset" class="btn btn-danger"/>
            
            </form>
        </div>
        <?php

            $url="http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
            if(strpos($url,"upload_failed")==true)
                echo "<p class='error'> Report upload failed </p>";
            else if(strpos($url,"upload_succeed")==true)
                echo "<p class='success'> Report upload succeed </p>";

        ?>
        <footer>
            <script src="js/main.js"></script>
        </footer>

        
       
    </body>
</html>
