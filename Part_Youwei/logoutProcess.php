<?php
//change login status and kill session
session_start();
$_SESSION['status'] = false;
unset($_SESSION['loginUser']);
echo '<script>alert("Log out Successfully"); window.location.href="./home.php";</script>';
