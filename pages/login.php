<?php
session_start();
require_once('../backend/form.php');
require_once('../backend/db/db.php');
require_once('../backend/auth.php');
require_once('../backend/page_controller.php');

PageController::init();

Form::$SESSION_NAME = 'login';
Form::init();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Form::updateContents();
    Form::updateErrors();

    if (!Form::hasErrors()) {
        if (Auth::login()) {
            if (!isset($_POST['remember'])) {
                unset($_SESSION[Form::$SESSION_NAME]);
            }

            if ($_POST['name'] === 'admin') {
                PageController::setCanAccess(true, 'toAdminRankings.php');
                PageController::setCanAccess(true, 'toAdminWelcome.php');
                PageController::setCanAccess(true, 'adminForum.php');
                header('Location: transition/toAdminWelcome.php');
                exit();
            }

            PageController::setCanAccess(true, 'welcome.php');
            PageController::setCanAccess(true, 'rankings.php');
            PageController::setCanAccess(true, 'forum.php');
            PageController::setCanAccess(false, 'login.php');
            PageController::setCanAccess(false, 'signup.php');
            header('Location: welcome.php');
            exit();
        } else {
            $_SESSION[Form::$SESSION_NAME]['name']['error'] = 'Username and Password does not match';
            $_SESSION[Form::$SESSION_NAME]['password']['error'] = 'Username and Password does not match';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felper</title>
    <link href="../css/pages/login_signup.css" rel="stylesheet">
    <link href="../css/dependencies/boxicons-2.1.4/css/boxicons.min.css" rel='stylesheet'>
    <script src="../backend/js/utils.js"></script>
</head>

<body>
    <div class="wrapper">
        <form method="post">
            <h1>Login</h1>
            <?php
            Form::inputText('name', Type::$Text, 'Username', "<i class='bx bxs-user'></i>", true);
            Form::inputPassword('password', 'Password', "<i class='bx bxs-lock-alt'></i>", true);
            ?>

            <div class="remember-forgot">
                <label><input type="checkbox" value="remember" id="remember" name="remember">Remember me</label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit" class="btn">Login</button>

            <div class="register-link">
                <p>Don't have an account? <a href="signup.php">Register</a></p>
            </div>
        </form>
    </div>
</body>

</html>