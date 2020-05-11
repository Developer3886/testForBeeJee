<?php
session_start ();
if (!$_SESSION['success']) {
    echo "<div class='col-12 text-center'>Session does not exist, register again</div>";
    echo "<a href='/'>Login</a>";
    exit;
}
require __DIR__.'/../models/connect.php';
$what_past = htmlspecialchars(strip_tags($_POST['task_text_edit']));
$id = htmlspecialchars(strip_tags($_POST['id']));
$link = Connects::connectDB ();
Connects::updateTask ($link, $id, $what_past);
Connects::closeDB ($link);
header('Location: ../');
?>
