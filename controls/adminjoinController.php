<?php
session_start ();
if ($_SESSION['success']) {
    $_SESSION['errors'][] = 'You are already registered';
    header('Location: ../');
    exit;
}

require __DIR__.'/../models/connect.php';
$login_ = htmlspecialchars(strip_tags($_POST['user_login']));
$pass_ = htmlspecialchars(strip_tags($_POST['user_pass']));
$link = Connects::connectDB ();

function validateLogin () {
    global $login_;
    global $link;
    if (!empty($login_)) {
        $existsLogin = Connects::chekLogin ($link, $login_);
        if ($existsLogin) return TRUE;
        else $_SESSION['errors'][] = 'Login not exists';
    }
    else $_SESSION['errors'][] = 'Login cannot be empty';
}

function validatePass () {
    global $login_;
    global $pass_;
    global $link;
    if (!empty($pass_)) {
        $correctPass = Connects::chekPass ($link, $login_, $pass_);
        if ($correctPass)
            return TRUE;
        else $_SESSION['errors'][] = 'Password incorrect';
    }
    else $_SESSION['errors'][] = 'Password cannot be empty';
}

$loginChek = validateLogin ();
$passChek = validatePass ();

if ($loginChek && $passChek) {
    $_SESSION['name'] = $login_;
    $_SESSION['success'] = 1;
}

Connects::closeDB ($link);
header('Location: ../');
?>
