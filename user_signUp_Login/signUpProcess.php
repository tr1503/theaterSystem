<?php
//get sign up input
$username = $_POST['username'];
$password = $_POST['password'];
$phone = $_POST['phone'];

//check input value
if ($username == '' || $password == ''){
    echo '<script>alert("Please enter your username and password."); history.go(-1);</script>';
}else{
    require_once 'dbConnect.php';
    dbConnect();
    $checkName = mysql_query("SELECT name FROM user WHERE name = '.$username.'");
    if (mysql_num_rows($checkName)>0){
        echo '<script>alert("This username is already taken by others. Please try another one."); history.go(-1);</script>';
    }else{
        $signUpUser = "INSERT INTO user(name, password, phone) VALUES ('$username','$password','$phone')";
        $result = mysql_query($signUpUser);
        if (!$result){
            echo '<script>alert("Please try again."); history.go(-1);</script>';
        }else{
            echo '<script>alert("Sign up Successfully!"); window.location.href="./login.php";;</script>';
        }
    }
}