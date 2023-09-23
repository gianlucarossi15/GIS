
<?php

    require_once("conn.php");
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!isset($_POST["latitude"]) || $_POST["latitude"]=="" || !isset($_POST["longitude"]) || $_POST["longitude"]==""){
            header("Location: index.php?coordinate_missing");
            exit;
        }
        echo $longitude=$_POST["longitude"];
        echo $latitude=$_POST["latitude"];
        
        $description;
        $image_name;
        $set=false;
        $target_file;
        $hole_type=$_POST["hole_type"];
        $date=date("Y-m-d");
        if(isset($_POST["description"]))
            $description=$_POST["description"];
        else
            $description="";
        if(is_uploaded_file($_FILES["hole_image"]["tmp_name"])){
            $type=["image/jpg","image/png","image/jpeg","image/svg"];
            //if the image format is allowed, we insert it
            if(in_array($_FILES['hole_image']['type'], $type, TRUE)){
                $set=true;
                $image_name = $_FILES['hole_image']['name'];
                $target_file = "report_images/". basename($image_name);
            }
            else{
                header("Location: index.php?bad_format");
                exit;
            }
                
            //otherwise we insert the report without the image
        }
        else
            $image_name=NULL;

        $coordinate = "POINT($longitude $latitude)";
        

        if($set){
            
            if(move_uploaded_file($_FILES['hole_image']['tmp_name'],$target_file)){
                $query = "INSERT INTO public.report (report_date, coordinate, hole_type, description, photo_name, photo_path) VALUES ($1, ST_GeomFromText($2), $3,  $4, $5, $6)";
                $res = pg_prepare($conn, "query", $query);
                $res=pg_execute($conn,"query",array($date, $coordinate, $hole_type, $description, $image_name, $target_file));

                if(!$res)
                    header("Location: index.php?upload_failed");
                else
                    header("Location: index.php?upload_succeed");
            }
            else
                header("Location: index.php?upload_failed");
        }
        else
        {   
            $query = "INSERT INTO public.report (report_date, coordinate, hole_type, description) VALUES ($1, ST_GeomFromText($2), $3,  $4)";
            $res = pg_prepare($conn, "query", $query);
            $res=pg_execute($conn,"query",array($date, $coordinate, $hole_type, $description));
            if(!$res)
                header("Location: index.php?upload_failed");
                
            else
                header("Location: index.php?upload_succeed");
        }
       
    }
    else 
        header("Location: index.php");


?>
