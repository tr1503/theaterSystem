<!DOCTYPE html>
<!--
user - merchandise
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
        <div id="merchandiseList">
            <?php
            $sql = "SELECT * FROM merchandise";
            $result = mysql_query($sql);
            $res_id = $_GET['res_id'];
            $user_id = $_GET['user_id'];
            //echo $res_id.$user_id;
            ?>
            <form method="post" action="confirmMerchandise.php">
            <table border="1">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
                <?php 
                $i = 0;
                while($row = mysql_fetch_array($result)){ 
                    $i++;
                    ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo '$'.$row['price'] ?></td>
                    <td>
                        <select name="amount">
                            <option value ="0" selected>0</option>
                            <option value ="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </td>
                </tr>
                <input type="hidden" name="merchandise_id" value="<?php echo $row['id'] ?>">                
                <?php 
                    } 
                ?>
            </table>            
            <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
            <input type="hidden" name="reserve_id" value="<?php echo $res_id ?>">
            <input type="submit" value="Buy">
            </form>
        </div>
        <div id="return">
            <input type='button' value='Return' onclick='history.go(-1)'>
        </div>
    </body>
</html>
