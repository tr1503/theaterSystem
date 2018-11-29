<!DOCTYPE html>
<!--
general terminal
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <?php
        //use credentials and function of dbConnect.php to connect
        require 'dbConnect.php';
        dbConnect();
        //echo 'Success';
        ?>
    </head>
    <body>
        <nav>
            <div class="homepageLink">
                <ul>
                    <li><a href="home.php">HYZtheater</a></li>
                </ul>
            </div>
            <div class="signLink">
                <ul>
                    <?php
                        //access to superglobal session, in other words check is there any logined user
                        session_start(); 
                        //if there is a login user display username, otherwise show login link
                        if ($_SESSION['status']==true){
                            echo '<li>'.$_SESSION['loginUser'].'</li>';
                            echo '<li><a href="logoutProcess.php">Log Out</a></li>';
                        }else{
                            echo '<li><a href="login.php">Login</a></li>';
                            echo '<li><a href="signUp.php">Sign Up</a></li>';
                        }
                    ?>
                </ul>
            </div>
        </nav>
        <div class="searchTitle">
            <h1>Search for movies</h1>
            <form method="post" action=""> <!--add later-->
                <input type="text" name="keywordTitle" maxlength="50">
                <input type="submit" value="Search">
            </form>
        </div>
        <div class="listLink">
            <ul>
                <li><a href="merchandiseList.php">Merchandise Provided</a></li>
                <li><a href="movieList.php">Top 250 Classic Movies</a></li>
                <li><a href="auditoriumList.php">Check Auditorium</a></li>
            </ul>
        </div>
    </body>
</html>
