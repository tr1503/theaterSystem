<!DOCTYPE html>
<html>
<head>
    <title>Manage Merchandise</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <?php
        require_once 'dbConnect.php';
        dbConnect();
    ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="empolyeeHome.php">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="navbar-text">
                    <?php 
                        session_start(); 
                        echo $_SESSION['loginUser'];
                    ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="logoutProcess.php">Logout</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Jobs
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="addMovie.php">Add new movies</a>
                        <a class="dropdown-item" href="manageMerchandise.php">Manage merchandise</a>
                        <a class="dropdown-item" href="auditoriumList.php">Manage screening</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="get" action="searchMarket.php">
                <input class="form-control mr-sm-2" type="search" name="title" placeholder="Search Movie Market" aria-label="Search">
                <input type="submit" class="btn btn-outline-success my-2 my-sm-0" value="search">
            </form>
        </div>
    </nav>
    <div id="merList" class="container">
        <?php
            $sql = "SELECT * FROM merchandise";
            $result = mysql_query($sql);
            ?>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php 
                while($row = mysql_fetch_array($result)){ 
                    ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo '$'.$row['price']; ?></td>
                    <td>
                        <form method="get" action="deleteMerchandise.php">
                            <input type="hidden" name="id" value="<?php echo $row['id']?>">
                            <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                    </td>
                    <td>
                        <form method="get" action="updateMerchandise.php">
                            <input type="hidden" name="id" value="<?php echo $row['id']?>">
                            <input type="hidden" name="name" value="<?php echo $row['name']?>">
                            <input type="hidden" name="price" value="<?php echo $row['price']?>">
                            <input type="submit" class="btn btn-warning" value="Update">
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
    </div>
    <div class="container">
        <input type='button' value='Add' class="btn btn-success" onclick='window.location.href="addMerchandise.php"'>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>