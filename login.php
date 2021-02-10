<?php
include "topbar.php";
$errorMessage = ""; // Displays any error message that may occur.
$redirectTo = $_GET['redirect_to']; // Does the user want to redirect to a page?
if (include "checkauth.php") $errorMessage = "You are already logged in. Do you want to log in again?"; // Simple reminder to remind the user they're logged in already.
else if (!empty($redirectTo)) $errorMessage = "Please login to access that page.";
if (isset($_POST['username'])) { // Only runs if a username value exists.
    $conn = include "database.php";
    $username = $conn -> real_escape_string(stripslashes($_REQUEST['username']));
    $password = $conn -> real_escape_string(stripslashes($_REQUEST['password']));
    $result = $conn -> query("SELECT * FROM `users` WHERE username='$username' and password=PASSWORD('$password')"); // Attempt to find the user.
    if ($result -> num_rows == 1) { // We're in!
        session_start();
        $_SESSION["username"] = $_REQUEST['username']; // Create a session cookie with the stored username
        if (empty($redirectTo)) header("Location: /new-website/"); // Redirect to either the home page or the redirect location, whichever is set.
        else header("Location: $redirectTo");
    }
    else $errorMessage = "Incorrect username or password. Try again."; // Oops... Nah, not today friend.
}
?>
<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <title>Ollie's Website</title>
        <link rel="stylesheet" type="text/css" href="/new-website/Styles/main.css">
    </head>
    <body>
        <div id="wrapper">
            <?php include "header.php" ?>
            <form method="POST" action="">
                <input type="text" name="username" placeholder="Username" maxlength="20"><br />
                <input type="password" name="password" placeholder="Password" maxlength="20"> <br />
                <input type="submit" name="submit" value="Login">
            </form>
            <div id="errortext"><?php echo $errorMessage; ?></div>
        </div>
    </body>
</html>