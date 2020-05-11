<?php
session_start ();
$how_sort_ = htmlspecialchars(strip_tags($_POST['how_sort']));
switch ($how_sort_) {
    case 'name_asc' :
        $_SESSION['sortBy'] = 'name_asc';
        $_SESSION['query'] = "SELECT ID, name, mail, texttask, valid, edit FROM tasks ORDER BY name ASC";
        break;
    case 'name_desc' :
        $_SESSION['sortBy'] = 'name_desc';
        $_SESSION['query'] = "SELECT ID, name, mail, texttask, valid, edit FROM tasks ORDER BY name DESC";
        break;
    case 'mail_asc' :
        $_SESSION['sortBy'] = 'mail_asc';
        $_SESSION['query'] = "SELECT ID, name, mail, texttask, valid, edit FROM tasks ORDER BY mail ";
        break;
    case 'mail_desc' :
        $_SESSION['sortBy'] = 'mail_desc';
        $_SESSION['query'] = "SELECT ID, name, mail, texttask, valid, edit FROM tasks ORDER BY mail DESC";
        break;
    case 'status_completed' :
        $_SESSION['sortBy'] = 'status_completed';
        $_SESSION['query'] = "SELECT ID, name, mail, texttask, valid, edit FROM tasks ORDER BY valid ASC";
        break;
    case 'status_not_comlete' :
        $_SESSION['sortBy'] = 'status_not_comlete';
        $_SESSION['query'] = "SELECT ID, name, mail, texttask, valid, edit FROM tasks ORDER BY valid DESC";
        break;
}
header('Location: ../');
?>
