<?php
    session_start();
    $id = $_SESSION['mer_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    if ($name == '' || $price == ''){
        echo '<script>alert("Please enter your merchandise information."); history.go(-1);</script>';
    } else {
        require_once 'dbConnect.php';
        dbConnect();
        $addMerchandise = "UPDATE merchandise SET name='$name', price='$price' WHERE id='$id'";
        $result = mysql_query($addMerchandise);
        if (!$result){
            echo '<script>alert("Please try again."); history.go(-1);</script>';
        }else{
            echo '<script>window.location.href="./manageMerchandise.php";</script>';
        }
    }
?>