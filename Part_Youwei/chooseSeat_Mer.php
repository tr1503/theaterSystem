<!DOCTYPE html>
<!--
user - choose screening
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <link rel="stylesheet" type="text/css" href="css/seatLayout.css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
        <?php
            session_start();
            //get auditorium id from screening
            $scr_id = $_GET['scr_id'];
            
            require_once 'dbConnect.php';
            dbConnect();
            
            $screen = mysql_fetch_array(mysql_query("SELECT aud_id FROM screening WHERE id = '$scr_id'"));
            $aud_id = $screen['aud_id'];
            
            /*get seat layout information from seat*/
            $getLayout = "SELECT * FROM seat WHERE aud_id='$aud_id'";
            $resultLayout = mysql_query($getLayout);
            //$layout = mysql_fetch_array(resultLayout);
            
            //seat number per row
            $getSeatNo = "SELECT number FROM seat WHERE aud_id = '$aud_id' AND row = '1'";
            $resultSeatNo = mysql_query($getSeatNo);
            while($seatNo = mysql_fetch_array($resultSeatNo)){
                $colNo[] = $seatNo['number'];
            }
            //print_r($colNo);
            
            //seat row number
            $getSeatRow = "SELECT row FROM seat WHERE aud_id = '$aud_id' AND number = '1'";
            $resultSeatRow = mysql_query($getSeatRow);
            while($seatRow = mysql_fetch_array($resultSeatRow)){
                $rowNo[] = $seatRow['row'];
            }
            //print_r($rowNo);
            
            //movie price per seat
            $getMoviePrice = "SELECT price FROM movie WHERE id=(
                              SELECT movie_id FROM screening WHERE id = '$scr_id')";
            $resultMoviePrice = mysql_query($getMoviePrice);
            $moviePriceRow = mysql_fetch_array($resultMoviePrice);
        ?>
    </head>
    <body>
        <div id="nav">
            <div id="homepageLink">
                <ul>
                    <li><a href="home.php">HYZtheater</a></li>
                </ul>
            </div>
            <div id="signLink">
                <ul>
                    <li><?php echo $_SESSION['loginUser'] ?></li>
                    <li><a href="logoutProcess.php">Log Out</a></li>
                </ul>
            </div>
        </div>
        <div id="seatLayout">
            <div id="screen"></div>
            <div id="seats">
                <?php 
                //output each row of seats
                for($i=0;$i<count($rowNo);$i++){ 
                    echo '<div class="seatsRow">';
                    //for each row, output each seat
                    for($j=0;$j<count($colNo);$j++){
                        echo '<div class="seat"></div>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
            <div id="booking">
                <div class="booking_left">Choose seat:
                    <div id="selected_seat"></div>                    
                    <div id="errMsg"></div>
                </div>
                <div class="booking_right">
                    <div id="total">Total price：<span> 0 </span></div>
                </div>                
             </div>
            <?php 
            $row_s =  "<script>document.ready(row_s)</script>";
            echo $row_s;
                    ?>
            <div id="button">
                <button id="bookNowButton" type="button" >Book Now</button>
            </div>
        </div>
    </body>
    <script>
    //Reference: http://www.zhimengzhe.com/HTMLjiaocheng/338198.html
    $(document).ready(function(){

        var seat_num ;
        var total_bill      = 0 ; //set default price
        var pricePerTicked  = <?php echo $moviePriceRow['price'] ?>; //price of the movie
        var maximumSeats    =   1; //seats limitation

        $('#bookNowButton').hide(); //hide the book button if no seats is selected

        $('.seat').each(function() {       
            var column_num = parseInt( $(this).index() ) + 1; //set column
            var row_num = parseInt( $(this).parent().index() )+1; //set row
            seat_num = row_num+"-"+column_num ; //set seat_num
            $(this).text(seat_num); //value seat_num
            $(this).addClass("seat"+seat_num);  //apply css color setting
        });
        
        $("#seats .seat").click(function() {  
            $('#errMsg').html('');
            if($(this).hasClass('select')){ //check if is chosen
                $(this).removeClass('select'); //if is chosen, remove current css for color
                $(this).css('background-color','#D8D8D8'); //apply original color

                var currentSeatClass = $(this).attr('class').split(' ')[1]; 

                console.log(currentSeatClass);
                $( "#selected_seat ."+currentSeatClass ).remove();

            }else if($(".your_selected_seat").length<maximumSeats && !$(this).hasClass('select')){ //check seats limitation
                $(this).css('background-color','#71DCAA'); //apply new color
                $(this).addClass("select"); //apply css

                var column_num = parseInt( $(this).index() ) + 1;
                var row_num = parseInt( $(this).parent().index() )+1;    
                $( "#selected_seat" ).append("<span class='your_selected_seat seat"+row_num+"-"+column_num+" '><b>"+row_num+"-"+column_num+"</b></br></span>");
                //var row_s = row_num;
                //var col_s = column_num;
            }else {
                $('#errMsg').html('You can only choose 1 seat once a time.');    
                }

            //if select seat show button; or it will disappear
            if($(".your_selected_seat").length){
                $('#bookNowButton').fadeIn(1000);
            }else {
                $('#bookNowButton').fadeOut(1000);
                }
            //check total price
            total_bill = $(".your_selected_seat").length * pricePerTicked;
            $('#total > span').html(total_bill);
        });
    });
</script>
</html>
