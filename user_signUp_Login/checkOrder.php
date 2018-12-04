<!DOCTYPE html>
<html>
<head>
    <title>Check Order</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php
        session_start();
        $name = $_SESSION['loginUser'];
        //configure database connection credential
        $server = 'localhost';
        $username = 'root';
        $password = 'mysql';
        $database = 'movie_theater';    
        //start connection, use database 'movie_theater'
        $conn = mysql_connect($server,$username,$password) or die("Connection failed: ".  mysql_error());
        mysql_select_db($database,$conn) or die("Connection failed: ".  mysql_error());
        $sql = "SELECT id FROM user WHERE name = '$name'";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_array($result)) {
            $id = $row['id'];
        }
        mysql_free_result($result);
        mysql_close($conn);
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="home.php">HYZtheater</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php 
                    echo '<li class="nav-item active"><a class="nav-link" href="checkOrder.php">'.$_SESSION['loginUser'].'</a></li>';
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
    <?php
        $server = 'localhost';
        $username = 'root';
        $password = 'mysql';
        $database = 'movie_theater';    
        //start connection, use database 'movie_theater'
        $conn = mysql_connect($server,$username,$password) or die("Connection failed: ".  mysql_error());
        mysql_select_db($database,$conn) or die("Connection failed: ".  mysql_error());
        $sql = "CALL showUserOrder('$id')";
        $order = mysql_query($sql);
    ?>
    <div id="orders" class="container">
        <h3 class="text-center">Your Orders</h3>
        <table class="table">
            <tr>
                <th>Reservation ID</th>
                <th>Movie</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
            </tr>
            <?php 
                while($row = mysql_fetch_array($order)){ 
            ?>
            <tr>
                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['title'] ?></td>
                <td><?php echo $row['start_time'] ?></td>
                <td><?php echo $row['end_time'] ?></td>
                <td><?php
                    if ($row['paid'] == 1) {
                        echo "Paid Process";
                    }
                    else {
                        echo "Paid Needs Process";
                    }
                ?></td>
            </tr>
            <?php 
                } 
                mysql_free_result($order);
            ?>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>  
</body>
</html>