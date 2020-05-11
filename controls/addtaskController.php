<?php
session_start ();
require __DIR__.'/../models/connect.php';
$name_ = htmlspecialchars(strip_tags($_POST['user_name']));
$mail_ = htmlspecialchars(strip_tags($_POST['user_mail']));
$text_ = htmlspecialchars(strip_tags($_POST['task_text']));
$link = Connects::connectDB ();

function validateName () {
    global $name_;
    global $mail_;
    global $link;
    if (!empty($name_))
        return TRUE;
    else $_SESSION['errors_addtask'][] = 'Name cannot be empty';
}

function validateMail () {
    global $mail_;
    if (!empty($mail_)) {
        if (filter_var($mail_, FILTER_VALIDATE_EMAIL))
            return TRUE;
        else $_SESSION['errors_addtask'][] = 'Email incorrect';
    }
    else $_SESSION['errors_addtask'][] = 'E-Mail cannot be empty';
}

function validateText () {
    global $text_;
    if (!empty($text_))
        return TRUE;
    else $_SESSION['errors_addtask'][] = 'Task`s text cannot be empty';
}

$name = validateName ();
$mail = validateMail ();
$text = validateText ();

if ($name && $mail && $text)
    Connects::addTask ($link, $name_, $mail_, $text_);

Connects::closeDB ($link);
header('Location: ../');
?>
