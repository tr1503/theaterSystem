<!DOCTYPE html>
<!--
user - check reservation
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <?php
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
                        echo '<li class="nav-item active"><a class="nav-link" href="checkReservation.php">'.$_SESSION['loginUser'].'</a></li>';
                        echo '<li class="nav-item active"><a class="nav-link" href="logoutProcess.php">Log Out</a></li>';
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
        <div id="checkOrder">            
            <?php
            $user = $_SESSION['loginUser'];
            $getUserId = "SELECT id FROM user WHERE name='$user'";
            $userIdResult = mysql_query($getUserId);
            $userIdRow = mysql_fetch_array($userIdResult);
            $userId = $userIdRow['id'];            
            
                //A: get reservation by time desc
                $sqlA = "SELECT * FROM reservation 
                        WHERE id IN (SELECT reserve_id FROM user_reserve WHERE user_id=$userId)
                        ORDER BY reserve_time DESC";
                $resultA = mysql_query($sqlA);
                //$rowA = mysql_fetch_array($resultA);
                while($rowA = mysql_fetch_array($resultA)){
                    $scr_id = $rowA['scr_id'];
                    //B: get screening information
                    $sqlB = "SELECT * FROM screening WHERE id='$scr_id'";
                    $resultB = mysql_query($sqlB);
                    $rowB = mysql_fetch_array($resultB);
                    //C: get seat information
                    $res_id = $rowA['id'];
                    $sqlC = "SELECT * FROM seat_reserve WHERE reserve_id='$res_id'";
                    $resultC = mysql_query($sqlC);
                    //D: get movie title
                    $movie_id = $rowB['movie_id'];
                    $sqlD = "SELECT * FROM movie WHERE id='$movie_id'";
                    $rowD = mysql_fetch_array(mysql_query($sqlD));
                    
                    //F: get auditorium information
                    $aud_id = $rowB['aud_id'];
                    $sqlF = "SELECT * FROM auditorium WHERE id='$aud_id'";
                    $rowF = mysql_fetch_array(mysql_query($sqlF));
            ?>
            <table class="table">
                <tr>
                    <td>Movie: <?php echo $rowD['title'] ?></td>
                    <td>Auditorium: <?php echo $rowF['name'] ?></td>
                </tr>                
               <?php 
                while($rowC = mysql_fetch_array($resultC)){
                $seat_id = $rowC['seat_id'];
                //E: get seat row and number
                $sqlE = "SELECT * FROM seat WHERE id='$seat_id'";
                $rowE = mysql_fetch_array(mysql_query($sqlE));
                   ?>
                <tr>
                    <td>Row: <?php echo $rowE['row'] ?></td>
                    <td>Column: <?php echo $rowE['number'] ?></td>
                </tr>
                <?php }?>                
                <tr>
                    <td>Start: <?php echo $rowB['start_time'] ?></td>
                    <td>End: <?php echo $rowB['end_time'] ?></td>
                </tr>
                <tr>
                    <td>Reserve time: <?php echo $rowA['reserve_time'] ?></td>
                    <td>Price: <?php echo '$'.$rowA['movie_payment'] ?></td>
                </tr>
                <tr>
                    <td>
                        <form method="get" action="buyMerchandise.php">
                            <input type="hidden" name="user_id" value="<?php echo $userId ?>">
                            <input type="hidden" name="res_id" value="<?php echo $res_id ?>">
                            <input type="submit" class="btn btn-success" value="Add Some Merchandise">
                        </form>
                        <form method="get" action="checkMerchandise.php">
                            <input type="hidden" name="res_id" value="<?php echo $res_id ?>">
                            <input type="submit" class="btn btn-warning" value="Check Merchandise">
                        </form>
                    </td>
                </tr>
            </table>
                <?php } ?>            
        </div>
        <div id="return">
            <input type='button' class="btn btn-primary" value='Return' onclick='history.go(-1)'>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>  
    </body>
</html>
