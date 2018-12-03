<?php
    $id = $_GET['id'];
    if ($id == "") {
        echo '<script>alert("You cannot go to this page directly."); history.go(-1);</script>';
    }
    require_once 'dbConnect.php';
    dbConnect();
    $deleteMerchandise = "DELETE FROM merchandise WHERE id='$id'";
    $result = mysql_query($deleteMerchandise);
    if (!$result){
        echo '<script>alert("Please try again."); history.go(-1);</script>';
    }else{
        echo '<script>window.location.href="./manageMerchandise.php";</script>';
    }
?>