<?php
require_once 'dbConnect.php';
dbConnect();
//process reservation
$scr_id = $_POST['scr_id'];
$movie_payment = $_POST['movie_payment'];
$paid = $_POST['paid'];
$reserve_time = $_POST['reserve_time'];
$seat_id = $_POST['seat_id'];
//print_r($seat_id);
session_start();
$username = $_SESSION['loginUser'];
//insert into reservation
$sql_1 = "INSERT INTO reservation (scr_id,movie_payment,paid,reserve_time)
          VALUES ('$scr_id','$movie_payment','$paid','$reserve_time')";
$sql_1Result = mysql_query($sql_1);

//select reservation id
$selectId = "SELECT id FROM reservation ORDER BY id DESC";
$selectResult = mysql_query($selectId);
$selectRow = mysql_fetch_array($selectResult);
$reserve_id = $selectRow['id'];
//echo $reserve_id;

//insert into seat_reserved and user_reserved
for($i=0;$i<count($seat_id);$i++){
$sql_2 = "INSERT INTO seat_reserve (reserve_id,seat_id,scr_id)
          VALUES ('$reserve_id','$seat_id[$i]','$scr_id')";
$sql_2Result = mysql_query($sql_2);
}

$selectUserId = mysql_query("SELECT id FROM user WHERE name='$username'");
$userIdRow = mysql_fetch_array($selectUserId);
$userId = $userIdRow['id'];

$sql_3 = "INSERT INTO user_reserve (user_id,reserve_id)
          VALUES ('$userId','$reserve_id')";
$sql_3Result = mysql_query($sql_3);

if(!$sql_1Result || !$sql_2Result || !$sql_3Result){
    echo '<script>alert("Wrong. Please try again."); history.go(-1);</script>';
}else{
    echo '<script>alert("Reserve Successfully!"); window.location.href="./home.php";;</script>';
}
        