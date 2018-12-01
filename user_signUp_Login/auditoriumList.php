<!DOCTYPE html>
<!--
general - aud list
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <?php 
        require_once 'dbConnect.php';
        dbConnect();
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
        <div id="audList">
            <?php
            $sql = "SELECT * FROM auditorium";
            $result = mysql_query($sql);
            ?>
            <table border="1">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Capacity</th>
                </tr>
                <?php 
                $i = 0;
                while($row = mysql_fetch_array($result)){ 
                    $i++;
                    ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['seats_no'] ?></td>
                </tr>
                <?php } ?>
            </table>
        </div> 
        <div id="return">
            <input type='button' value='Return' onclick='history.go(-1)'>
        </div>
    </body>
</html>
