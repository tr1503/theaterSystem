<!DOCTYPE html>
<!--
general terminal - sign up
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
        <div id="userSignUp">
            <h2>Sign Up</h2>
            <form method="post" action="signUpProcess.php">
                <div>
                    Username: <input type="text" name="username" maxlength="15">*
                </div>
                <div>
                    Password: <input type="text" name="password" maxlength="10">*
                </div>
                <div>
                    Phone: <input type="text" name="phone" maxlength="10">
                </div>
                <input type="submit" value="Register">
            </form>
            <a href="login.php">Already have an account?</a>
        </div>
    </body>
</html>
