<!--Author: Oluwatomi-->
<!--Date: 2021/12/07-->
<!--Description: A Process to Delete Books-->
<?php


session_start();

if($_SESSION['loggedIn'] == false){
    header('location: index.php');
}
// extract the GET variable isbn
if(isset($_GET['bookId'])) {

    //id exist in the url
    $bookId = $_GET['bookId'];

    // connect to db
    require("lib/config.php");

    $bookId = $mysqli->real_escape_string($bookId);

    // get the data for just the book we want to edit!
    $query = "SELECT * FROM books WHERE books.id = $bookId";
    $result = $mysqli->query($query);

    $num_results = $result->num_rows;

    if ($num_results == 0) {
        $message = "Book not found.";
    } else {
        $row = $result->fetch_assoc();
        $isbn = $row['isbn'];
        $title = $row['title'];
        $author = $row['author'];
        $price = $row['price'];
    }

    $result->free();
    $mysqli->close();
} else {
    //the id is not provided
    $message = "Sorry, no id provided.";
}
?>
<!doctype html>
<html>
<head>
    <title>Book-O-Rama - Delete Book Entry</title>
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
    include ('header.php')
    ?>
    <!-- <p><a href="newBook.php">Add a new book</a> - <a href="inventory.php">View all Books</a></p>-->

    <h1>Book-O-Rama - Delete Book Entry</h1>
    <?php
    // if message gets set above it means there is a problem and we don't have a book with that id to edit or it isn't provided
    if (isset($message)) {
        echo $message;
    } else {
        // we have all we need so let's display the book
        ?>

        <div class="newBook-form">

            <form action="delete.php? "method="GET">

                <fieldset  class="scheduler-border">
                    <legend  class="scheduler-border">Book-O-Rama - Delete Book</legend>
                    <div class="form-group">
                        <label for="isbn">ISBN (format 0-672-31509-2):</label>
                        <input type="text" class="form-control" id="isbn" value='<?php echo $isbn ?>' placeholder="Enter book isbn" name="isbn" readonly>
                    </div>
                    <div class="form-group">
                        <label for="author">Author:</label>
                        <input type="text" class="form-control" id="author" value='<?php echo $author ?>' placeholder="Enter book author" name="author" readonly>
                    </div>
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" value='<?php echo $title ?>' placeholder="Enter book title" name="title" readonly>
                    </div>
                    <div class="form-group">
                        <label for="price">Price $</label>
                        <input type="text" class="form-control" id="price" value='<?php echo $price ?>' placeholder="Enter book price" name="price" readonly>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="bookId" value='<?php echo $bookId ?>'  name="bookId">
                        <p><em>Note: You are about to delete a book. Are you sure you want to delete a Book?</em></p>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Delete</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <?php
    } // close the if no book found $message above
    ?>
</body>
</html>
