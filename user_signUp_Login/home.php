<!DOCTYPE html>
<!--
general terminal
-->
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">  
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <?php
        //use credentials and function of dbConnect.php to connect
        require 'dbConnect.php';
        dbConnect();
        //get id of top 5 rating movies
        $getTop5 = "SELECT * FROM movie ORDER BY rating DESC LIMIT 5;";
        $result = mysql_query($getTop5);
        //create an array to store the id of top 5 movies
        $i = 0;
        while($row = mysql_fetch_array($result)){
            $id[$i] = $row['id'];
            $name[$i] = $row['title'];
            $i++;
        }
        ?>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="home.php">HYZtheater</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?php
                        //access to superglobal session, in other words check is there any logined user
                        session_start(); 
                        //if there is a login user display username, otherwise show login link
                        if ($_SESSION['status']==true){
                            echo '<li class="nav-item active"><a class="nav-link" href="#">'.$_SESSION['loginUser'].'</a></li>';
                            echo '<li class="nav-item active"><a class="nav-link" href="logoutProcess.php">Log Out</a></li>';
                        }else{
                            echo '<li class="nav-item active"><a class="nav-link" href="login.php">Login</a></li>';
                            echo '<li class="nav-item active"><a class="nav-link" href="signUp.php">Sign Up</a></li>';
                        }
                        echo '<li class="nav-item active"><a class="nav-link" href="movieList.php">Movies</a></li>';
                        echo '<li class="nav-item active"><a class="nav-link" href="merchandiseList.php">Merchandises</a></li>';
                    ?>
                </ul>
                <form class="form-inline my-2 my-lg-0" method="get" action="searchMovie.php">
                    <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
                    <input type="submit" class="btn btn-outline-success my-2 my-sm-0" value="search">
                </form>
            </div>
        </nav> 
        <div>
            <h3 class="text-center">Top 5 movies</h3>
        </div>
        <div id="filmCarousel" class="carousel slide" style="width: 400px; margin: 0 auto" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#filmCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#filmCarousel" data-slide-to="1"></li>
                <li data-target="#filmCarousel" data-slide-to="2"></li>
                <li data-target="#filmCarousel" data-slide-to="3"></li>
                <li data-target="#filmCarousel" data-slide-to="4"></li>
            </ol>
            <div class="carousel-inner">
                <?php
                    for ($i = 0; $i < 5; $i++) {
                        if ($i == 0)
                            echo '<div class="carousel-item active">';
                        else
                            echo '<div class="carousel-item">';
                        echo "<a href='movieDetail_Book.php?id={$id[$i]}'><img class='d-block w-100' src='./img/{$id[$i]}.jpg'></a>";
                        echo "<div class='carousel-caption d-none d-md-block'>";
                        echo "<h5>{$name[$i]}</h5>";
                        echo '</div></div>';
                    }
                ?>
            </div>
            <a class="carousel-control-prev" href="#filmCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#filmCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>  
    </body>
</html>
