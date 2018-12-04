<!DOCTYPE html>
<html>
<head>
    <title>Check Merchandise</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <?php
            //check login status, otherwise lead to login page
            session_start();
            if (isset($_SESSION['status']) && $_SESSION['status']==true){
                require_once 'dbConnect.php';
                dbConnect();
            }else{                
                echo '<script>alert("Please login firstly."); window.location.href="./book_login.php";</script>';
            }
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
                    echo '<li class="nav-item active"><a class="nav-link" href="checkReservation.php">'.$_SESSION['loginUser'].'</a></li>';
                    echo '<li class="nav-item active"><a class="nav-link" href="logoutProcess.php">Log Out</a></li>';
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
    <?php
        $res_id = $_GET['res_id'];
        $sql = "SELECT merchandise.name, merchandise_order.price, merchandise_order.amount, merchandise_order.order_time FROM merchandise JOIN merchandise_order ON merchandise_order.merchandise_id = merchandise.id WHERE merchandise_order.reserve_id = '$res_id'";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_array($result)){
    ?>
    <tr>
        <td><?php echo $row['name'] ?></td>
        <td><?php echo $row['amount'] ?></td>
        <td><?php echo "$".$row['price'] ?></td>
        <td><?php echo $row['order_time'] ?></td>
    </tr>
    <?php } ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>  
</body>
</html>