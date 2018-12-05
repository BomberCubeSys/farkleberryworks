<?php
if (!isset($_SESSION)) {session_start();}

function isLoggedInSecured(){
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1){
        if(time() - $_SESSION['time'] < 900){
            //If last request is within 15 minutes
            $_SESSION['time'] = time(); //Update session time to current time as Unix timestamp of integer type
        }
        else{
            $sessionTimeOutMessage = 'SESSION HAS TIMED OUT. Please Log In.'; //creates a message to be displayed in homepage
            session_unset(); //Unset all $_SESSION variables
            session_destroy(); //Destroy session data
            header("/index.php"); //Redirect to home
        }
    }
}
function isLoggedInGeneral(){
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1){
        if(time() - $_SESSION['time'] < 900){
            //If last request is within 15 minutes
            $_SESSION['time'] = time(); //Update session time to current time as Unix timestamp of integer type
        }
    }
}
