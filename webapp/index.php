<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <?php 
            include("navbar.php");
         ?> 
       
    </head>
    <body>
        <div class="text-center main_title">Roads management for the City of Padova</div>
        <?php

            $url="http://$_SERVER[HTTP_POST]$_SERVER[REQUEST_URI]";
            if(strpos($url,"upload_failed")==true)
                echo "<div class='alert alert-danger text-center'> Report upload failed </div>";
            else if(strpos($url,"coordinate_missing")==true)
                echo "<div class='alert alert-danger text-center'> Coordinate not present </div>";
            else if(strpos($url,"bad_format")==true)
                echo "<div class='alert alert-danger text-center'>File format not allowed </div>";
            else if(strpos($url,"upload_succeed")==true)
                echo "<div class='alert alert-success text-center'> Report upload succeed </div>";

        ?>
    
       
        <div id="map" class="map">
        </div>
        <!-- <a href="https://www.openstreetmap.org/copyright" target="_blank"> © OpenStreetMap contributors</a> -->

        <div class="ol-attribution ol-unselectable ol-control ol-uncollapsible" style="pointer-events: auto;"><button type="button" aria-expanded="true" title="Attributions"><span class="ol-attribution-collapse">›</span></button><ul><li>© <a href="https://www.openstreetmap.org/copyright" target="_blank" data-focus-mouse="false">OpenStreetMap</a> contributors.</li></ul></div>
        <br>
        <div class="text-center title report-title">Submit a new report</div>
        <div class="col-12">
            <div>
                <form action="insert_report.php" method="POST" class="form rounded" id="hole_report" enctype="multipart/form-data">
                    <br/>
                    <div id="popup" class="ol-popup">
                        <span id="popup-closer" class="ol-popup-closer"></span>
                        <div id="popup-content" name="popup-content"></div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-4">
                                <label class="font-weight-bold" for="h_t">Type of hole</label> <br>
                            </div>
                            <div class="col-4 text-center">
                                <label class="font-weight-bold" for="dscrpt" >Insert a description</label>
                            </div>
                            <div class="col-4 ">
                                <label class="font-weight-bold image" for="h_i"> Select an image</label>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-4 ">    
                                    <select class="form-select" name="hole_type" id="h_t" required>
                                        <option value="" hidden></option>
                                        <option value="Small">Small</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Large">Large</option>
                                    </select>
                                </div>
                                <div class="col-4 text-left">  
                                    <input type="text" id="dscrpt" name="description" placeholder="Description here" class="form-control">
                                </div>
                                <div class="col-4 text-right">  
                                    <input type="file" name="hole_image" id="h_i" accept="image/jpg, image/png, image/jpeg, image/svg">
                                </div>
                            </div>    
                            <div class="col text-center mt-5 mb-3">
                                <input type="submit" class="btn btn-success " name="submit" />   
                                <input type="reset" class="btn btn-danger"/>
                            </div>
                        
                    </div>

                
                    
                    <!--used to get the coordinate to the DB-->
                    <input type="hidden"  name="latitude" id="latitude" value="" required/>
                    <input type="hidden" name="longitude" id="longitude" value="" required/>


                </form> 
            </div>
        </div>
    </body>
    <footer>
        <?php
            include("footer.php"); 
        ?>
        <script src="js/main.js"></script>
    </footer>
</html>
