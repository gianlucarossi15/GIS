<?php

    session_start();
    include("include.html");
    
    require_once("conn.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST["username"]) && isset($_POST["password"])){
            $username=$_POST["username"];
            $password=md5($_POST["password"]);
            
            $query = "SELECT * FROM public.user WHERE username=$1 AND password=$2";
            $res = pg_prepare($conn, "query", $query);
            $res=pg_execute($conn,"query",array($username, $password));
            if (!$res){
                echo "An error occurred.\n";

                exit;
            }
            if(pg_num_rows($res)==1){
                $_SESSION["username"]=$username;
                $_SESSION["password"]=$password;
                header("Location: list_reports.php");
                exit;
            }
            else
                header("Location: login.php");
           
        }
        else
            header("Location: login.php");
    }
    else
        header("Location: login.php");
    
?>