<!DOCTYPE html>
<html>
<head>
    <title>Choose Time</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <?php
        //configure database connection credential
        $server = 'localhost';
        $username = 'root';
        $password = 'mysql';
        $database = 'movie_theater';
        
        //start connection, use database 'movie_theater'
        $conn = mysql_connect($server,$username,$password) or die("Connection failed: ".  mysql_error());
        mysql_select_db($database,$conn) or die("Connection failed: ".  mysql_error());
    ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="employeeHome.php">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="navbar-text">
                    <?php 
                        session_start(); 
                        echo $_SESSION['loginUser'];
                    ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="lougoutProcess.php">Logout</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Jobs
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="addMovie.php">Add new movies</a>
                        <a class="dropdown-item" href="#">Manage merchandise</a>
                        <a class="dropdown-item" href="auditoriumList.php">Manage screening</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <?php
        session_start();
        $title = $_POST['title'];
        $duration = $_POST['duration'];
        $date = $_POST['date'];
        $aud_id = $_SESSION['aud_id'];
        $_SESSION['date'] = $date;
        $_SESSION['duration'] = $duration;
        if ($title == "" || $duration == "" || $date == "") {
            echo '<script>alert("Please enter correct title, duration and date."); history.go(-1);</script>';
        } 
        $findMovie = "select id from movie where title = '$title'";
        $result = mysql_query($findMovie);
        while ($value = mysql_fetch_array($result)) {
            $movie_id = $value['id'];
        }
        $_SESSION['movie_id'] = $movie_id;
        $start1 = $date." 08:00:00";
        $start2 = $date." 13:00:00";
        $start3 = $date." 20:00:00";
        $sql1 = "CALL searchFreeTime('$start1','$aud_id')";
        $sql2 = "CALL searchFreeTime('$start2','$aud_id')";
        $sql3 = "CALL searchFreeTime('$start3','$aud_id')";
        $time1 = mysql_query($sql1);
    ?>
    <div class="container">
        <table class="table">
            <tr>
                <th>Start Time</th>
                <th>End Time</th>
                <th></th>
            </tr>
            <?php
                if (mysql_num_rows($time1) == 0) {
                    echo "<tr>";
                    echo "<td>".$start1."</td>";
                    $end1 = date('Y-m-d H:i:s', strtotime($start1) + $duration*60);
                    echo "<td>".$end1."</td>";
                    echo '<td><form method="get" action="addScreening.php"><input type="hidden" name="start" value="'.$start1.'"><input type="hidden" name="end" value="'.$end1.'"><input type="submit" class="btn btn-info" value="Choose"></form></td>';
                    echo "</tr>";
                }
                mysql_free_result($time1);
                mysql_close($conn);
                $conn = mysql_connect($server,$username,$password) or die("Connection failed: ".  mysql_error());
                mysql_select_db($database,$conn) or die("Connection failed: ".  mysql_error());
                $time2 = mysql_query($sql2);
                if (mysql_num_rows($time2) == 0) {
                    echo "<tr>";
                    echo "<td>".$start2."</td>";
                    $end2 = date('Y-m-d H:i:s', strtotime($start2) + $duration*60);
                    echo "<td>".$end2."</td>";
                    echo '<td><form method="get" action="addScreening.php"><input type="hidden" name="start" value="'.$start2.'"><input type="hidden" name="end" value="'.$end2.'"><input type="submit" class="btn btn-info" value="Choose"></form></td>';
                    echo "</tr>";
                }
                mysql_free_result($time2);
                mysql_close($conn);
                $conn = mysql_connect($server,$username,$password) or die("Connection failed: ".  mysql_error());
                mysql_select_db($database,$conn) or die("Connection failed: ".  mysql_error());
                $time3 = mysql_query($sql3);
                if (mysql_num_rows($time3) == 0) {
                    echo "<tr>";
                    echo "<td>".$start3."</td>";
                    $end3 = date('Y-m-d H:i:s', strtotime($start3) + $duration*60);
                    echo "<td>".$end3."</td>";
                    echo '<td><form method="get" action="addScreening.php"><input type="hidden" name="start" value="'.$start3.'"><input type="hidden" name="end" value="'.$end3.'"><input type="submit" class="btn btn-info" value="Choose"></form></td>';
                    echo "</tr>";
                }
                mysql_free_result($time3);
            ?>
        </table>    
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>