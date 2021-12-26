<!--Author: Oluwatomi-->
<!--Date: 2021/12/07-->
<!--Description: A process to delete a book-->

<?php

// Include config file
require_once("lib/config.php");
$bookId = "";
// Process delete operation after confirmation

if (isset($_GET["bookId"]) && !empty($_GET["bookId"])) {
    //Sanitize the parameter
    $bookId = $mysqli->real_escape_string($_GET['bookId']);
    // example UPDATE query
    $query = "DELETE FROM books WHERE books.id =$bookId";
    $result = $mysqli->query($query);

    header("location: index.php");
    $mysqli->close();

}

header("location: index.php");
