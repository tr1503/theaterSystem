<!DOCTYPE html>
<!--
user - book seat
-->
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <?php
            $id = $_GET['id'];
            //check login status, otherwise lead to login page
            session_start();
            if (isset($_SESSION['status']) && $_SESSION['status']==true){
                require_once 'dbConnect.php';
                dbConnect();
            }else{                
                echo '<script>alert("Please login firstly."); window.location.href="./book_login.php";</script>';
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
                            echo '<li class="navbar-text">'.$_SESSION['loginUser'].'</li>';
                            echo '<li class="nav-item active"><a class="nav-link" href="logoutProcess.php">Log Out</a></li>';
                            echo '<li class="nav-item active"><a class="nav-link" href="movieList.php">Reserve</a></li>';
                        }else{
                            echo '<li class="nav-item active"><a class="nav-link" href="login.php">Login</a></li>';
                            echo '<li class="nav-item active"><a class="nav-link" href="signUp.php">Sign Up</a></li>';
                        }
                    ?>
                </ul>
                <form class="form-inline my-2 my-lg-0" method="get" action="searchMovie.php">
                    <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
                    <input type="submit" class="btn btn-outline-success my-2 my-sm-0" value="search">
                </form>
            </div>
        </nav> 
        <div class="container" id="container">
            <h3>Please choose an screening sesion:</h3>
            <?php 
                $sql = "SELECT a.name,s.id,s.start_time,s.end_time
                        FROM screening s JOIN auditorium a ON s.aud_id=a.id
                        WHERE s.movie_id = '$id'";
                $result = mysql_query($sql);                
            ?>
            <table class="table">
                <tr>
                    <th>Auditorium</th>
                    <th>Start time</th>
                    <th>End time</th>
                    <th></th>
                </tr>
                <?php while($row = mysql_fetch_array($result)){ ?>
                <tr>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['start_time'] ?></td>
                    <td><?php echo $row['end_time'] ?></td>
                    <td>
                        <form method="get" action="chooseSeat_Mer.php">
                            <input type="hidden" name="scr_id" value="<?php echo $row['id'] ?>">
                            <input type="submit" class="btn btn-success" value="Book">
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <footer id="return">
            <input type='button' class="btn btn-primary" value='Return' onclick='history.go(-1)'>
        </footer>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
