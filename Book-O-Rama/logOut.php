<!--Author: Oluwatomi-->
<!--Date: 2021/12/07-->
<!--Description: LogOut process -->

<?php
session_start();
// check for logged in session
if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'])
{
    // user is not logged in
    // re-direct user to index.php
    header("Location: index.php");
    exit;
}else{
    //Set username from $_SESSION associative array
    $userName = $_SESSION["username"];

    // Remove all of the session variables.
    session_unset();

// Delete the session cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

// Destroy the session

    if(session_destroy())
    {
        header("Location: index.php?message=logout&userName=".$userName);
        exit;
    }

}

