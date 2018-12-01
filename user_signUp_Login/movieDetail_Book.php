<!DOCTYPE html>
<!--
general - movie details & book a seat
-->
<html>
    <head>
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
        <div id="container">
            <h3>Movie Details</h3>
            <div id="movieDetails">
                <?php
                    //get movie details
                    $sqlMovie = "SELECT * FROM movie WHERE id = '$id'";                    
                    $resultM = mysql_query($sqlMovie);                    
                    $rowM = mysql_fetch_array($resultM);                   
                ?>
                <span>Title: <?php echo $rowM['title'] ?></span><br>
                <span>Director: <?php echo $rowM['director'] ?></span><br>
                <span>Rating: <?php echo $rowM['rating'] ?></span><br>
                <span>Price: <?php echo $rowM['price'] ?></span><br>
            </div>
            <div id="audDetails">
                <table border="1">
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
                    <input type="submit" value="Book A Seat">
                </form>
            </div>
        </div>
        <div id="return">
            <input type='button' value='Return' onclick='history.go(-1)'>
        </div>
    </body>
</html>
