<!DOCTYPE html>
<!--
user - order confirm
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <?php        
        //check if there is seat or die
        if(count($_GET['seatId'])==0){
            echo '<script>alert("Please choose a seat."); history.go(-1);</script>';
            die;
        }
        $seatId = $_GET['seatId'];
        $moviePrice = $_GET['moviePrice'];
        $scr_id = $_GET['scr_id'];
        

        require_once 'dbConnect.php';
        dbConnect();
        //get name of movie and auditorium
        $getM_A = "SELECT m.id AS movie_id,m.title AS movie_title,a.id AS aud_id,a.name AS aud_name
                   FROM movie m, auditorium a
                   WHERE m.id=(SELECT movie_id FROM screening WHERE id=1)
                   AND a.id=(SELECT aud_id FROM screening WHERE id=1)";
        $resultM_A = mysql_query($getM_A);
        $M_ARow = mysql_fetch_array($resultM_A);
        //get information of screening
        $getScr = "SELECT * FROM screening WHERE id=$scr_id";
        $resultScr = mysql_query($getScr);
        $scrRow = mysql_fetch_array($resultScr);
        ?>
    </head>
    <body>
        <div id="confirmReservation">
            <table borther="1">
                <tr>
                    <td>Title: <?php echo $M_ARow['movie_title'] ?></td>
                </tr>
                <tr>
                    <td>Auditorium: <?php echo $M_ARow['aud_name'] ?> </td>                    
                </tr>
                <?php for($i=0;$i<count($seatId);$i++){ 
                    //echo $seatId[$i];
                    $getSeat = "SELECT * FROM seat WHERE id=$seatId[$i]";
                    $resultSeat = mysql_query($getSeat);
                    $seatRow = mysql_fetch_array($resultSeat);
                    ?>
                <tr>
                    <td>seat: <?php echo $seatRow['row'].'-'.$seatRow['number'] ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td>Start time: <?php echo $scrRow['start_time'] ?></td>
                    <td>End time: <?php echo $scrRow['end_time'] ?></td>
                </tr>
                <tr>
                    <td>Total price: <?php $i=count($seatId);$price = $i * $moviePrice; echo $price; ?></td>
                </tr>
            </table>
            <form method="post" action="processReservation.php">
                <input type="hidden" name="scr_id" value="<?php echo $scr_id ?>">
                <input type="hidden" name="movie_payment" value="<?php echo $price ?>">
                <input type="hidden" name="paid" value="0">
                <input type="hidden" name="reserve_time" value="<?php echo date("Y-m-d H:i:s") //insert current time?>">                
                <?php for($i=0;$i<count($seatId);$i++){  ?>
                <input type="hidden" name="seat_id[]" value="<?php echo $seatId[$i] ?>">
                <?php } ?>
                <input type='button' value='Return' onclick='history.go(-1)'>
                <input type="submit" value="Confirm">
            </form>
        </div>
    </body>
</html>
