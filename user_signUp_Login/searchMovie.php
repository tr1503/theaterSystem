<!DOCTYPE html>
<!--
general terminal - search
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <?php
        $keyword = $_GET['keyword'];
        //use credentials and function of dbConnect.php to connect
        require_once 'dbConnect.php';
        dbConnect();
        //search movies by title keyword
        $sql = "SELECT * FROM movie WHERE title LIKE '%$keyword%'";
        $result = mysql_query($sql);
        ?>
    </head>
    <body>
        <nav>
            <div id="homepageLink">
                <ul>
                    <li><a href="home.php">HYZtheater</a></li>
                </ul>
            </div>
            <div id="signLink">
                <ul>
                    <?php
                        //access to superglobal session, in other words, check is there any logined user
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
        </nav>
        <div id="searchDisplay">
            <h2>Search results: </h2>
            <table>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Director</th>
                    <th>Rating</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                <?php 
                    //print rows for all returned value
                    $i=0;
                    while($row = mysql_fetch_array($result)){                        
                    $i++;
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $row['title'] ?></td>
                    <td><?php echo $row['director'] ?></td>
                    <td><?php echo $row['rating'] ?></td>
                    <td><?php echo "$".$row['price'] ?></td>
                    <td>
                        <form method="get" action="movieDetail_Book.php">
                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                            <input type="submit" value="Details">
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <label><?php echo "(Total: ".$i." results)" ?></label>
        </div>
        <div>
            <input type='button' value='Return' onclick='history.go(-1)'>
        </div>
    </body>
</html>
