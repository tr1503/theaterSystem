<!DOCTYPE html>
<!--
user - require login before booking
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HYZtheater</title>
    </head>
    <body>
        <div id="nav">
            <div id="homepageLink">
                <ul>
                    <li><a href="home.php">HYZtheater</a></li>
                </ul>
            </div>
        </div>
        <div id="userLogin">
            <h2>User Login</h2>
            <form method="post" action="book_loginProcess.php">
                <div>
                    Username: <input type="text" name="username" maxlength="15">
                </div>
                <div>
                    Password: <input type="text" name="password" maxlength="10">
                </div>
                <input type="submit" value="Login">
            </form>
            <a href="signUp.php">First here?</a>
        </div>
    </body>
</html>
