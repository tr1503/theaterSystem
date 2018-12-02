<?php
    $title = $_POST['title'];
    $director = $_POST['director'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    if ($title == '' || $director == '' || $rating == '' || $price == ''){
        echo '<script>alert("Please enter your username and password."); history.go(-1);</script>';
    } else {
        require_once 'dbConnect.php';
        dbConnect();
        $addMovie = "INSERT INTO movie(title, director, rating, price) VALUES ('$title','$director','$rating','$price')";
        $result = mysql_query($addMovie);
        if (!$result){
            echo '<script>alert("Please try again."); history.go(-1);</script>';
        }else{
            echo '<script>window.location.href="./addMovie.html";</script>';
        }
    }

?>