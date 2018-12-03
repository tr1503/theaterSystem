<?php
    $name = $_POST['name'];
    $price = $_POST['price'];
    if ($name == '' || $price == ''){
        echo '<script>alert("Please enter your merchandise information."); history.go(-1);</script>';
    } else {
        require_once 'dbConnect.php';
        dbConnect();
        $addMerchandise = "INSERT INTO merchandise(name, price) VALUES ('$name','$price')";
        $result = mysql_query($addMerchandise);
        if (!$result){
            echo '<script>alert("Please try again."); history.go(-1);</script>';
        }else{
            echo '<script>window.location.href="./addMerchandise.html";</script>';
        }
    }
?>