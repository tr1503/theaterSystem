<!DOCTYPE html>
<!--
general terminal
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <link rel="stylesheet" type="text/css" href="css/home.css" />
        <?php
        //use credentials and function of dbConnect.php to connect
        require_once 'dbConnect.php';
        dbConnect();
        //get id of top 5 rating movies
        $getTop5 = "SELECT * FROM movie ORDER BY rating DESC LIMIT 5;";
        $result = mysql_query($getTop5);
        //create an array to store the id of top 5 movies
        $i = 0;
        while($row = mysql_fetch_array($result)){
        $id[$i] = $row['id'];
        $i++;
        }
        ?>
    </head>
    <body>
        <div id="nav">
            <div id="homepageLink">
                <ul>
                    <li><a href="home.php">HYZtheater</a></li>
                </ul>
            </div>
            <div id="signLink">
                <ul>
                    <?php
                        //access to superglobal session, in other words, check any logined user
                        session_start(); 
                        //if there is a login user display username, otherwise show login link
                        if (isset($_SESSION['status']) && $_SESSION['status']==true){
                            echo '<li>'.$_SESSION['loginUser'].'</li>';
                            echo '<li><a href="logoutProcess.php">Log Out</a></li>';
                        }else{
                            echo '<li><a href="login.php">Login</a></li>';
                            echo '<li><a href="signUp.php">Sign Up</a></li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div id="searchTitle">
            <h1>Movie Search</h1>
            <form method="get" action="searchMovie.php"> 
                <input type="text" name="keyword" maxlength="50">
                <input type="submit" value="Search">
            </form>
        </div>
        <div id="slide">
            <h3>TOP 5</h3>
            <div id="frame">
            <div id="photos" class="play">
                <a href="movieDetail_Book.php?id=<?php echo $id[0]; ?>"><img src="img/TheShawshankRedemption.jpg" /></a>
                <a href="movieDetail_Book.php?id=<?php echo $id[1]; ?>"><img src="img/TheGodfather.jpg" /></a>
                <a href="movieDetail_Book.php?id=<?php echo $id[2]; ?>"><img src="img/TheGodfatherPartII.jpg" /></a>
                <a href="movieDetail_Book.php?id=<?php echo $id[3]; ?>"><img src="img/TheDarkKnight.jpg" /></a>
                <a href="movieDetail_Book.php?id=<?php echo $id[4]; ?>"><img src="img/12AngryMen.jpg" /></a>
                <ul id="dis">
                    <li>The Shawshank Redemption</li>
                    <li>The Godfather</li>
                    <li>The Godfather: Part II</li>
                    <li>The Dark Knight</li>
                    <li>12 Angry Men</li>
                </ul>
            </div>
            </div>
        </div>        
        <div id="listLink">
            <h3>Check What We Have:</h3>
            <ul>
                <li><a href="merchandiseList.php">Merchandise Provided</a></li>
                <li><a href="movieList.php">Top 50 Classic Movies</a></li>
                <li><a href="auditoriumList.php">Auditoriums</a></li>
            </ul>
        </div>
    </body>
</html>
