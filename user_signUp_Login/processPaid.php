<?php
    $id = $_GET['id'];
    if ($id == ''){
        echo '<script>alert("You cannot process paid directly"); history.go(-1);</script>';
    } else {
        require_once 'dbConnect.php';
        dbConnect();
        $updatePaid = "UPDATE reservation SET paid=1 WHERE id='$id'";
        $result = mysql_query($updatePaid);
        if (!$result){
            echo '<script>alert("Please try again."); history.go(-1);</script>';
        }else{
            echo '<script>window.location.href="./manageReservation.php";</script>';
        }
    }
?>