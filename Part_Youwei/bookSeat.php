<!DOCTYPE html>
<!--
user - book seat
-->
<html>
    <head>
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
        <div id="container">
            <h3>Please choose an screening sesion:</h3>
            <?php 
                $sql = "SELECT a.name,s.id,s.start_time,s.end_time
                        FROM screening s JOIN auditorium a ON s.aud_id=a.id
                        WHERE s.movie_id = '$id'";
                $result = mysql_query($sql);                
            ?>
            <table border="1">
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
                        <form method="get" action="chooseSeat.php">
                            <input type="hidden" name="scr_id" value="<?php echo $row['id'] ?>">
                            <input type="submit" value="Book">
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <div id="return">
            <input type='button' value='Return' onclick='history.go(-1)'>
        </div>
    </body>
</html>
