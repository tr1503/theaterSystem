<?php
//function to connect
function dbConnect(){
    //configure database connection credential
    $server = 'localhost';
    $username = 'root';
    $password = '294737157';
    $database = 'movie_theater';
    
    //start connection, use database 'movie_theater'
    $conn = mysql_connect($server,$username,$password) or die("Connection failed: ".  mysql_error());
    mysql_select_db($database,$conn) or die("Connection failed: ".  mysql_error());
}
?>

