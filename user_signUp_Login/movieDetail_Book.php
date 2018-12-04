<!DOCTYPE html>
<!--
general - movie details & book a seat
-->
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <?php
            require_once 'dbConnect.php';
            dbConnect();
            $id = $_GET['id'];
            //echo $id;
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
                            echo '<li class="nav-item active"><a class="nav-link" href="checkOrder.php">'.$_SESSION['loginUser'].'</a></li>';
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
                    <input class="form-control mr-sm-2" name="keyword" type="search" placeholder="Search" aria-label="Search">
                    <input type="submit" class="btn btn-outline-success my-2 my-sm-0" value="search">
                </form>
            </div>
        </nav>
        <div id="container">
            <h3 class="text-center">Movie Details</h3>
            <div id="movieDetails" class="text-center">
                <?php
                    //get movie details
                    $sqlMovie = "SELECT * FROM movie WHERE id = '$id'";                    
                    $resultM = mysql_query($sqlMovie);                    
                    $rowM = mysql_fetch_array($resultM);                   
                ?>
                <span><strong>Title: </strong><?php echo $rowM['title'] ?></span><br>
                <span><strong>Director: </strong><?php echo $rowM['director'] ?></span><br>
                <span><strong>Rating: </strong><?php echo $rowM['rating'] ?></span><br>
                <span><strong>Price: </strong><?php echo "$".$rowM['price'] ?></span><br>
            </div>
            <div id="audDetails">
                <table class="table">
                    <tr>
                        <th>Auditorium</th>
                        <th>Seats number</th>
                    </tr>
                <?php
                    //get info of all auditoriums which display this movie
                    $sqlAuditorium = "SELECT a.name,a.seats_no FROM movie m JOIN screening s ON m.id=s.movie_id
                                      JOIN auditorium a ON s.aud_id=a.id 
                                      WHERE s.movie_id = '$id'
                                      GROUP BY a.id";
                    $resultA = mysql_query($sqlAuditorium);
                    while($rowA = mysql_fetch_array($resultA)){
                ?>
                    <tr>
                        <td><?php echo $rowA['name'] ?></td>
                        <td><?php echo $rowA['seats_no'] ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div> 
            <div id="bookButton">
                <form method="get" action="bookSeat.php">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="submit" class="btn btn-success" value="Book A Seat">
                </form>
            </div>
        </div>
        <footer id="return">
            <input type='button' value='Return' class="btn btn-primary" onclick='history.go(-1)'>
        </footer>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
