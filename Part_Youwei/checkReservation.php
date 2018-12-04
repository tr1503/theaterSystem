<!DOCTYPE html>
<!--
user - check reservation
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HYZtheater</title>
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
        <div id="nav">
            <div id="homepageLink">
                <ul>
                    <li><a href="home.php">HYZtheater</a></li>
                </ul>
            </div>
            <div id="signLink">
                <ul>
                    <li><?php echo $_SESSION['loginUser'] ?></li>
                    <li><a href="logoutProcess.php">Log Out</a></li>
                </ul>
            </div>
        </div>
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
            <table border="1">
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
                        <form method="get" action="addMerchandise.php">
                            <input type="hidden" name="user_id" value="<?php echo $userId ?>">
                            <input type="hidden" name="res_id" value="<?php echo $res_id ?>">
                            <input type="submit" value="Add Some Merchandise">
                        <form>
                    </td>
                </tr>
            </table>
                <?php } ?>            
        </div>
        <div id="return">
            <input type='button' value='Return' onclick='history.go(-1)'>
        </div>
    </body>
</html>
