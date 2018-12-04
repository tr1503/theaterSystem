<!DOCTYPE html>
<html>
<head>
	<title>Employee Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php
        //configure database connection credential
        session_start(); 
        $employeeName = $_SESSION['loginUser'];
        $server = 'localhost';
        $username = 'root';
        $password = 'mysql';
        $database = 'movie_theater';    
        //start connection, use database 'movie_theater'
        $conn = mysql_connect($server,$username,$password) or die("Connection failed: ".  mysql_error());
        mysql_select_db($database,$conn) or die("Connection failed: ".  mysql_error());
        $sql = "SELECT aud_id FROM employee WHERE name='$employeeName'";
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)) {
            $aud_id = $row['aud_id'];
        }
        mysql_free_result($result);
        mysql_close($conn);

        $server = 'localhost';
        $username = 'root';
        $password = 'mysql';
        $database = 'movie_theater';    
        //start connection, use database 'movie_theater'
        $conn = mysql_connect($server,$username,$password) or die("Connection failed: ".  mysql_error());
        mysql_select_db($database,$conn) or die("Connection failed: ".  mysql_error());
        $sql = "CALL showOrder('$aud_id')";
        $notify = mysql_query($sql);
        if (mysql_num_rows($notify) != 0) {
            echo '<div class="alert alert-warning" role="alert">Some order need to process paid.<a href="manageReservation.php?audId='.$aud_id.'" class="alert-link">Click here to work</a></div>';
        }
        mysql_free_result($notify);
        mysql_close($conn);
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="empolyeeHome.php">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="navbar-text">
                    <?php 
                        echo $_SESSION['loginUser'];
                    ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="logoutProcess.php">Logout</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Jobs
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="addMovie.php">Add new movies</a>
                        <a class="dropdown-item" href="manageMerchandise.php">Manage merchandise</a>
                        <a class="dropdown-item" href="auditoriumList.php">Manage screening</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="get" action="searchMarket.php">
                <input class="form-control mr-sm-2" type="search" name="title" placeholder="Search Movie Market" aria-label="Search">
                <input type="submit" class="btn btn-outline-success my-2 my-sm-0" value="search">
            </form>
        </div>
    </nav>
    <?php
        //configure database connection credential
        $server = 'localhost';
        $username = 'root';
        $password = 'mysql';
        $database = 'movie_theater';    
        //start connection, use database 'movie_theater'
        $conn = mysql_connect($server,$username,$password) or die("Connection failed: ".  mysql_error());
        mysql_select_db($database,$conn) or die("Connection failed: ".  mysql_error());
        $sql = "CALL topMovie(10)";
        $top = mysql_query($sql);
    ?>
    <div id="topMovies" class="container">
        <h3 class="text-center">Top 10 Popular Movies</h3>
        <table class="table">
            <tr>
                <th>Movie</th>
                <th>Reservation</th>
            </tr>
            <?php 
                while($row = mysql_fetch_array($top)){ 
            ?>
            <tr>
                <td><?php echo $row['title'] ?></td>
                <td><?php echo $row['reserve'] ?></td>
            </tr>
            <?php 
                } 
                mysql_free_result($top);
            ?>
        </table>
    </div> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>