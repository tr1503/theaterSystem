<!DOCTYPE html>
<!--
general - movie list 50
-->
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <?php 
        require_once 'dbConnect.php';
        dbConnect();
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
        <div id="movieList" class="container">
            <?php
            $sql = "SELECT * FROM movie ORDER BY rating DESC";
            $result = mysql_query($sql);
            ?>
            <table class="table">
                <tr>
                    <th>Title</th>
                    <th>Director</th>
                    <th>Rating</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                <?php 
                while($row = mysql_fetch_array($result)){ 
                    ?>
                <tr>
                    <td><?php echo $row['title'] ?></td>
                    <td><?php echo $row['director'] ?></td>
                    <td><?php echo $row['rating'] ?></td>
                    <td><?php echo "$".$row['price'] ?></td>
                    <td>
                        <form method="get" action="movieDetail_Book.php">
                            <input type="hidden" name="id" value="<?php echo $row['id']?>">
                            <input type="submit" class="btn btn-info" value="Details">
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div> 
        <div id="return">
            <input type='button' value='Return' class="btn btn-primary" onclick='history.go(-1)'>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
