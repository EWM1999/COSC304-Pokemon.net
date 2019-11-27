<?php
    if(!isset($_SESSION)){ 
        session_start(); 
    } 
    if(isset($_SESSION['authenticatedUser'])){
        // they're logged in :)
        echo("<div class=\"login_things\">");
        echo("<h5 style=\"color:#EAEBED\">Logged in as: ".$_SESSION['authenticatedUser']."</h5>");
        // then they should be able to see their info and logout
        echo("<a class=\"login_things\" href=\"customer.php\">Customer Info</a><br>");
        if($_SESSION["admin"] == 1){
            // they're an admin user :)
            // and have access to the admin page
            echo("<a class=\"login_things\" href=\"admin.php\">Administrator</a><br>");
        }
        echo("<a class=\"login_things\" href=\"logout.php\">Log Out</a>");
        echo("</div>");
        }else{
        // they aren't logged in
        echo("<div class=\"login_things\"><a class=\"login_things\" href=\"login.php\">Log In</a></div>");

        }
    ?>
