<?php
//get login input
$username = $_POST['username'];
$password = $_POST['password'];

if ($username == '' || $password == ''){
    echo '<script>alert("Please enter your username and password."); history.go(-1);</script>';
}else{
    require_once 'dbConnect.php';
    dbConnect();
    //check valid user
    $checkValid = "SELECT * FROM user WHERE name = '$username' AND password = '$password'";
    $result = mysql_query($checkValid);
    if (mysql_num_rows($result)==1){
        session_start();
        $_SESSION['status'] = true;
        $_SESSION['loginUser'] = $username;
        echo '<script>alert("Log in Successfully!"); window.location.href="./home.php";</script>';
    }else{
        echo '<script>alert("Please try again."); history.go(-1);</script>';
    }
}
