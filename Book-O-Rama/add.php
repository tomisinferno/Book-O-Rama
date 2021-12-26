<!--Author: Oluwatomi-->
<!--Date: 2021/12/07-->
<!--Description: Process to add Book-->

<?php
session_start();
if ($_SESSION['loggedIn'] == false) {
    header('location: index.php');
}
?>

<html>
<head>
    <title>Book-O-Rama - Add</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
<div id="container">
    <?php
    include('header.php')
    ?>
    <h1>Book-O-Rama</h1>
    <?php
    $isbn = $_GET['isbn'] ?? null;
    $author = $_GET['author'] ?? null;
    $title = $_GET['title'] ?? null;
    $price = $_GET['price'] ?? null;

    //If Fields are empty
    if (empty($isbn) || empty($author) || empty($title) || empty($price)) {

        echo "You have not entered all the required details.<br />"
            . "Please go back and try again.</body></html>";
        exit();

    }

    require_once('lib/config.php');

    $isbn = $mysqli->real_escape_string($isbn);
    $author = $mysqli->real_escape_string($author);
    $title = $mysqli->real_escape_string($title);
    $price = $mysqli->real_escape_string(doubleval($price));

    if (mysqli_connect_errno()) {
        echo "Error: Could not connect to database.  Please try again later.";
        exit;
    }

    //Query to add values into database
    $query = "INSERT INTO books VALUES (NULL, '" . $isbn . "', '" . $author . "', '" . $title . "', " . $price . ")";
    //echo $query;
    $result = $mysqli->query($query);

    if ($result) {
        echo $mysqli->affected_rows . " book inserted into database. <a href='addBook.php'>Add another?</a>";

        //Display book inventory
        $query = "SELECT * FROM books";

        $result = $mysqli->query($query);

        $num_results = $result->num_rows;

        echo "<p>Number of books found: " . $num_results . "</p>";

        echo "<h2>CIS Book Inventory</h2>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
        if ($num_results > 0) {
            //returning a numeric array of all the books retrieved with the query
            $books = $result->fetch_all(MYSQLI_ASSOC);
            echo "<table class='table table-bordered'><tr>";

            //This dynamically retrieves header names
            foreach ($books[0] as $k => $v) {
                echo "<th>" . $k . "</th>";
            }
            echo "</thead>";
            echo "<tbody>";
            //Create a new row for each book
            foreach ($books as $book) {
                echo "<tr>";

                foreach ($book as $k => $v) {

                    echo "<td>" . $v . "</td>";

                }
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        }
        $result->free();
        $mysqli->close();
    } else {
        echo "An error has occurred.  The item was not added. <a href='addBook.php'>Try again?</a>";
    }


    ?>
</div>
</body>
</html>