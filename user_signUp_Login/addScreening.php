<?php
    session_start();
    $start = $_GET['start'];
    $end = $_GET['end'];
    $date = $_SESSION['date'];
    $duration = $_SESSION['duration'];
    $movie_id = $_SESSION['movie_id'];
    $aud_id = $_SESSION['aud_id'];
    if ($start == "" || $end == "" || $date == "" || $movie_id == "" || $aud_id == "") {
        echo '<script>alert("Please enter correct time."); history.go(-1);</script>';
    }
    require_once 'dbConnect.php';
    dbConnect();
    $addScreening = "INSERT INTO screening (movie_id, aud_id, start_time, end_time) VALUES ('$movie_id','$aud_id','$start','$end')";
    $result = mysql_query($addScreening);
    if (!$result){
        echo '<script>alert("Please try again."); history.go(-1);</script>';
    }else{
        echo '<script>window.location.href="./addScreening.html";</script>';
    }
?>