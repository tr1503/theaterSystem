<!DOCTYPE html>
<!--
user - confirm merchandise order
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HYZtheater</title>
        <?php
        $user_id = $_POST['user_id'];
        $reserve_id = $_POST['reserve_id'];
        $merchandise_id = $_POST['merchandise_id'];
        $amount = $_POST['amount'];
        echo $user_id.'<br>';
        echo $reserve_id.'<br>';
        echo $merchandise_id.'<br>';
        echo $amount;
        ?>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
