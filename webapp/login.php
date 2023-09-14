<?php
    session_start();
    if(isset($_SESSION["username"]) && isset($_SESSION["password"])){
        header("Location: list_reports.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/login.css" type="text/css">
    </head>
    <body>
        <form action="perform_login.php" method="POST">
            <div>
                <label for="user">Insert your username</label>
                <input type="text" id="user" name="username" required>
            </div>
            <div>
                <label for="psw">Insert your password</label>
                <input type="password" id="psw" name="password" required>
            </div>
            <input type="submit" name="submit" />
        </form>
    </body>
</html>