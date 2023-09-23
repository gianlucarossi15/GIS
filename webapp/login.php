<?php
    session_start();
    if(isset($_SESSION["username"]) && isset($_SESSION["password"])){
        header("Location: list_reports.php");
        exit;
    }
    include("include.html");
    include("navbar.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/login.css" type="text/css">
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 col-sm-9 col-xs-11">
                <form action="perform_login.php" method="POST">
                    <div class="card bg-light p-4 m-6 ">
                        <div><label for="user" class="font-weight-bold">Insert your username</label></div><br/>
                        <div><input type="text" id="user" name="username" required>  </div><br/>
                        <div><label for="psw" class="font-weight-bold">Insert your password</label></div> <br/>
                        <div><input type="password" id="psw" name="password" required></div>   <br>
                    <br/>
                    <input type="submit" name="submit" class=" btn btn-primary btn-lg ">
                    </div>
                </form>
            </div>
        </div>
        
    </body>
    <footer>
        <?php
            include("footer.php"); 
        ?>  
    </footer>
</html>