<!--Author: Oluwatomi-->
<!--Date: 2021/12/07-->
<!--Description: Process to edit Books in database-->
<?php
session_start();

if($_SESSION['loggedIn'] == false){
    header('location: index.php');
}


if(isset($_GET['bookId'])) {
// extract the GET variable
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
    <title>Book-O-Rama - Edit Book Entry</title>
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

    <h1>Book-O-Rama - Edit Book Entry</h1>
    <?php
    // if message gets set above it means there is a problem and we don't have a book with that id to edit or it isn't provided
    if (isset($message)) {
        echo $message;
    } else {
        ?>

        <div class="newBook-form">
            <form action="edit.php" method="GET">
                <fieldset  class="scheduler-border">
                    <legend  class="scheduler-border">Book-O-Rama - Edit Book</legend>
                    <div class="form-group">
                        <label for="isbn">ISBN (format 0-672-31509-2):</label>
                        <input type="text" class="form-control" id="isbn" value='<?php echo $isbn ?>' placeholder="Enter book isbn" name="isbn">
                    </div>
                    <div class="form-group">
                        <label for="author">Author:</label>
                        <input type="text" class="form-control" id="author" value='<?php echo $author ?>' placeholder="Enter book author" name="author">
                    </div>
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" value='<?php echo $title ?>' placeholder="Enter book title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="price">Price $</label>
                        <input type="text" class="form-control" id="price" value='<?php echo $price ?>' placeholder="Enter book price" name="price">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="bookId" value='<?php echo $bookId ?>'  name="bookId">
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Update</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <?php
    } // close the if no book found $message above
    ?>
</body>
</html>
