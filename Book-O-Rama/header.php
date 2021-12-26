<!--Author: Oluwatomi-->
<!--Date: 2021/12/07-->
<!--Description: Header to be added to every page-->

<br>
<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Book-O-Rama</a>
        </div>
        <?php
        if ($_SESSION['loggedIn'] == false){
            echo '
            <div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Log In
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-item">
                        <form class="login-form" action="#" method="post">
                            <input type="text" name="username" class="form-control" placeholder="Username"><br>
                            <input type="password" name="password" class="form-control" placeholder="Password"><br>

                            <input type="submit" class="btn btn-info" name="submit" value="Log In">
                        </form>
                    </div>
                </div>';
        }else if($_SESSION['loggedIn'] == true){
            echo "<p style='font-size: 15px; float: right'><a href='logOut.php'>Log Out</a></p>";
        }?>
</nav>
<br>