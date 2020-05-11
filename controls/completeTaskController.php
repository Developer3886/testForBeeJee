<?php
session_start ();
require __DIR__.'/../models/connect.php';
$link = Connects::connectDB ();
$id = htmlspecialchars(strip_tags($_GET['id']));
Connects::completeTask ($link, $id);
Connects::closeDB ($link);
header('Location: ../');
?>
