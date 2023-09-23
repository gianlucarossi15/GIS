<?php
    include("include.html");
?>
<!DOCTYPE html>
<html>
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
   </head>
   <body>
        <div class=" s-white-wrapper--header snipcss-QJjOg ">
            <header class=" l-header s-header" role="banner">
                <div class="l-header__logo">
                <br/>
                    <a href="index.php"><img class="l-header__logo" src="images/logo.png"></a>
                    <div class="teta">
                        <a href="#" title="Comune di Padova" class="s-logo">
                            <!-- <img src="images/comunePadova.png"> -->
                            <!-- <img src="images/logo.png"> -->
                            <span>rete civica del</span>
                            <br>
                            <strong>Comune di Padova</strong>
                        </a>
                    </div>
                </div>
                <br/>  <br/>
                <div class="l-header__navigation">
                    <h2 class="element-invisible">menu header</h2>
                    <ul class="menu">
                        <li class="menu-999 first"><a href="#">URP</a></li>
                        <li class="menu-28035"><a href="#" title="">Ufficio Stampa</a></li>
                        <li class="menu-1001"><a href="#">Newsletter</a></li>
                        <li class="menu-1002"><a href="#">Social Media</a></li>
                        <li class="menu-1003"><a href="#">Contatti</a></li>
                        <li class="menu-28040 last"><a href="#" title="">Padova Partecipa!</a></li>
                    </ul>
                </div>
                <div class="social-links l-header__social-links">
                    <a target="_blank" class="social-links__icon--instagram" href="https://www.instagram.com/comunepadova/" title="Follow us on instagram"><img src="images/icon__instagram.png"></a>
                    <a target="_blank" class="social-links__icon--twitter" href="https://twitter.com/comunepadova" title="Follow us on Twitter"><img src="images/icon__twitter.png"></a>
                    <a target="_blank" class="social-links__icon--facebook" href="https://www.facebook.com/Comune.Padova" title="Follow us on Facebook"><img src="images/icon__facebook.png"></a>
                    <a target="_blank" class="social-links__icon--rss" href="https://www.padovanet.it/informazione/servizio-rss-di-padovanet" title="rss"><img src="images/icon__rss.png"></a>
                </div>       
            </header>
        </div>
        <?php
            session_start();
            if(isset($_SESSION["username"]) && isset($_SESSION["password"])){
                $user=$_SESSION["username"];
                echo "<div class=''>";
                echo "<div class='navbar row justify-content-center text-center'>";
                echo "<div class='col-auto'><a href='index.php'>HOMEPAGE</a></div>";
                echo "<div class='col-auto'><a href='list_reports.php'>LIST REPORTS</a></div>";
                echo "<div class='col-auto'><span> You are logged in as: $user</span></div>";
                echo "<div class='col-auto'><a href='logout.php'>LOGOUT</a></div>";
                echo "</div></div>";
            }
            else
            { 
                echo "<div class=''>";
                echo "<div class='navbar row justify-content-center text-center'>";
                echo "<div class='col'><a href='index.php'>HOMEPAGE</a></div>";
                echo "<div class='col'><a href='list_reports.php'>LIST REPORTS</a></div>";
                echo "<div class='col'><a href='login.php'>LOGIN</a></div>";
                echo "</div></div>";
            }
        ?>
        <br/> <br/>
   </body>
   
</html>
