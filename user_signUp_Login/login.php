<!DOCTYPE html>
<!--
general terminal - login
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HYZtheater</title>
    </head>
    <body>
        <nav>
            <div class="homepageLink">
                <ul>
                    <li><a href="home.php">HYZtheater</a></li>
                </ul>
            </div>
        </nav>
        <div class="userLogin">
            <h2>User Login</h2>
            <form method="post" action="loginProcess.php">
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
