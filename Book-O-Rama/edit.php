<!--Author: Oluwatomi-->
<!--Date: 2021/12/07-->
<!--Description: Process to edit Books-->


<?php

if($_SESSION['loggedIn'] == false){
    header('location: index.php');
}
// Include config file
require_once("lib/config.php");
$bookId = "";
$isbn = "";
$author = "";
$title = "";
$price = "";
// Process edit operation after confirmation

if (isset($_GET["bookId"]) && !empty($_GET["bookId"])) {
    //Sanitize the parameter
    $bookId = $mysqli->real_escape_string($_GET['bookId']);
    $isbn = $mysqli->real_escape_string($_GET['isbn']);
    $author = $mysqli->real_escape_string($_GET['author']);
    $title = $mysqli->real_escape_string($_GET['title']);
    $price = $mysqli->real_escape_string(doubleval($_GET['price']));
    // UPDATE query
    $query = "UPDATE books SET isbn='$isbn', title='$title', author='$author', price=$price WHERE books.id=$bookId LIMIT 1";
    $result = $mysqli->query($query);

}
?>
<html>
<head>
    <title>Book-O-Rama - Update</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
<div id="container">
    <h1>Book-O-Rama</h1>
    <?php
    if ($result) {
        echo $mysqli->affected_rows . " book updated in database. <a href='index.php'>Go back</a>";
        //select book
        //Order Detail Report Query
        $query = "SELECT *
             FROM `books`
                where books.id=$bookId";

        $result = $mysqli->query($query);

        $num_results = $result->num_rows;

        //echo "<p>Total Results: $num_results</p>";

        if ($num_results > 0) {
            //returning a numeric array of all the books retrieved with the query
            $books = $result->fetch_all(MYSQLI_ASSOC);

            echo "<table class='table table-bordered'><tr>";
            //This dynamically retieves header names
            foreach ($books[0] as $k => $v) {
                echo "<th>" . $k . "</th>";
            }
            echo "</tr>";
            //Create a new row for each book
            foreach ($books as $book) {
                echo "<tr>";
                foreach ($book as $k => $v) {
                    echo "<td>" . $v . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            // if no results
            echo "<p>Sorry there are no entries in the database.</p>";
        }
        $result->free();
        $mysqli->close();

    } else {
        echo "An error has occurred.  The item was not updated.";
    }

    ?>
</div>
</body>
</html>