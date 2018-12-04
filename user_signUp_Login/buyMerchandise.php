<!DOCTYPE html>
<!--
user - merchandise
-->
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="home.php">HYZtheater</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?php
                        if ($_SESSION['status']==true){
                            echo '<li class="nav-item active"><a class="nav-link" href="checkReservation.php">'.$_SESSION['loginUser'].'</a></li>';
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
        <div id="merchandiseList" class="container">
            <?php
            $sql = "SELECT * FROM merchandise";
            $result = mysql_query($sql);
            $res_id = $_GET['res_id'];
            $user_id = $_GET['user_id'];
            //echo $res_id.$user_id;
            ?>
            <form method="post" action="confirmMerchandise.php">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
                <?php 
                $i = 0;
                while($row = mysql_fetch_array($result)){ 
                    ?>
                <tr>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo '$'.$row['price'] ?></td>
                    <td>
                        <select name="amount" class="form-control">
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
            <input type="submit" class="btn btn-success" value="Buy">
            </form>
        </div>
        <div id="return">
            <input type='button' class="btn btn-primary" value='Return' onclick='history.go(-1)'>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
