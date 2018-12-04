<!DOCTYPE html>
<!--
user - choose screening
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <link rel="stylesheet" type="text/css" href="css/seatLayout.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <!--script src="https://code.jquery.com/jquery-3.3.1.min.js"></script--> 
        <?php
            session_start();
            //get auditorium id from screening
            $scr_id = $_GET['scr_id'];
            
            require_once 'dbConnect.php';
            dbConnect();
            //get auditorium id
            $screen = mysql_fetch_array(mysql_query("SELECT aud_id FROM screening WHERE id = '$scr_id'"));
            $aud_id = $screen['aud_id'];            
            
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
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="home.php">HYZtheater</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?php
                        //access to superglobal session, in other words check is there any logined user
                        session_start(); 
                        //if there is a login user display username, otherwise show login link
                        if ($_SESSION['status']==true){
                            echo '<li class="nav-item active"><a class="nav-link" href="checkOrder.php">'.$_SESSION['loginUser'].'</a></li>';
                            echo '<li class="nav-item active"><a class="nav-link" href="logoutProcess.php">Log Out</a></li>';
                        }else{
                            echo '<li class="nav-item active"><a class="nav-link" href="login.php">Login</a></li>';
                            echo '<li class="nav-item active"><a class="nav-link" href="signUp.php">Sign Up</a></li>';
                        }
                        echo '<li class="nav-item active"><a class="nav-link" href="movieList.php">Movies</a></li>';
                        echo '<li class="nav-item active"><a class="nav-link" href="merchandiseList.php">Merchandises</a></li>';
                    ?>
                </ul>
                <form class="form-inline my-2 my-lg-0" method="get" action="searchMovie.php">
                    <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
                    <input type="submit" class="btn btn-outline-success my-2 my-sm-0" value="search">
                </form>
            </div>
        </nav>
        <div id="seatLayout">
            <form method="get" action="confirm.php">
            <div id="screen"></div>
            <div id="seats">
                
                <?php 
                //output each row of seats
                for($i=0;$i<count($rowNo);$i++){ 
                    echo '<div class="seatsRow">';
                    //for each row, output each seat
                    for($j=0;$j<count($colNo);$j++){ 
                        //get seat id for each seat
                        $getSeatId = "SELECT id FROM seat WHERE aud_id='$aud_id' AND row='$rowNo[$i]' AND number='$colNo[$j]'";
                        $resultSeatId = mysql_query($getSeatId);
                        $seatIdRow = mysql_fetch_array($resultSeatId);
                        ?>
                        <div class="seat">
                            <input type="checkbox" name="seatId[]" value="<?php echo $seatIdRow['id'] ?>">
                            <label><?php echo $rowNo[$i] ?>-<?php echo $colNo[$j] ?></label>
                            <input type="hidden" name="moviePrice" value="<?php echo $moviePriceRow['price'] ?>">
                            <input type="hidden" name="scr_id" value="<?php echo $scr_id ?>">
                        </div>
                    <?php }
                    echo '</div>';
                }
                ?>                                    
            </div>
        <input type="submit" class="btn btn-success" value="Book Seat" >
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
    <script>
    //Reference: http://www.zhimengzhe.com/HTMLjiaocheng/338198.html
    /* NOT USED IN THIS PROJECT
    $(document).ready(function(){

        var seat_num ;
        var total_bill      = 0 ; //set default price
        var pricePerTicked  = 10; //price of the movie
        var maximumSeats    =   1; //seats limitation

        
        $('.seat').each(function() {       
            var column_num = parseInt( $(this).index() ) + 1; //set column
            var row_num = parseInt( $(this).parent().index() )+1; //set row
            seat_num = row_num+"-"+column_num ; //set seat_num
            $(this).text(seat_num); //value seat_num
            $(this).addClass("seat"+seat_num);  //apply css color setting
        });
        */
        /*
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
        */
    });
</script>
</html>
