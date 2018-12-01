<!DOCTYPE html>
<!--
general terminal
-->
<html>
    <head>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">  
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <?php
        //use credentials and function of dbConnect.php to connect
        require 'dbConnect.php';
        dbConnect();
        //echo 'Success';
        ?>
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-nav-demo" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="home.php" class="navbar-brand">HYZtheater</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <?php
                            //access to superglobal session, in other words check is there any logined user
                            session_start(); 
                            //if there is a login user display username, otherwise show login link
                            if ($_SESSION['status']==true){
                                echo '<li class="navbar-text">'.$_SESSION['loginUser'].'</li>';
                                echo '<li><a href="logoutProcess.php">Log Out</a></li>';
                            }else{
                                echo '<li><a href="login.php">Login</a></li>';
                                echo '<li><a href="signUp.php">Sign Up</a></li>';
                            }
                        ?>
                    </ul>
                    <form class="navbar-form navbar-left" method="post" action="">
                        <div class="form-group">
                            <input type="text" name="keywordTitle" class="form-control" placeholder="Search">
                        </div>
                        <input type="submit" class="btn btn-default" value="Search">
                    </form>
                </div>    
            </div>
        </nav>
        <div class="listLink container">
            <div class="row">
                <!-- <div class="col-lg-6 col-sm-12">
                    <div class="thumbnail">
                        <a href="merchandiseList.php"><img src="https://images-na.ssl-images-amazon.com/images/I/61ADQzFODSL._SX466_.jpg"></a>
                    </div>
                </div> -->
                <div class="col-sm-12 col-lg-6">
                    <div class="thumbnail">
                        <img src="https://i5.walmartimages.com/asr/fa64ba40-2883-427d-95d3-1c0843cbffe2_1.c46da19e133159e365982a08602a5a77.jpeg" width="60%">
                        <div class="caption">
                            <h3>Merchandises</h3>
                            <p>Purchase merchandises by clicking here.</p>
                            <p><a href="merchandiseList.php" class="btn btn-primary" role="button">Buy</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="thumbnail">
                        <img src="https://assets.weforum.org/editor/8Ao5F6QxbgXHZvpvDAfcOq8VwRcoLPhYHZp3z-HwpBY.jpg" width="60%">
                        <div class="caption">
                            <h3>Movie List</h3>
                            <p>Reserve seats by clicking here.</p>
                            <p><a href="movieList.php" class="btn btn-primary" role="button">Reserve</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>  
    </body>
</html>
