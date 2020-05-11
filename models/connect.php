<?php
session_start ();
class Connects {
    static function connectDB () {
        $link = mysqli_connect ('127.0.0.1', 'root', 'root', 'testbee');
        if (!$link) die ('Невозможно установить соединение с MySQL');
            else return $link;
    }

    static function closeDB ($link) {
        mysqli_close ($link);
    }

    static function chekLogin ($link, $login) {
        $query = "SELECT name FROM users WHERE name = ?";
        $stmt = mysqli_prepare ($link, $query);
        mysqli_stmt_bind_param ($stmt, "s", $login);
        $result = mysqli_stmt_execute ($stmt);
        mysqli_stmt_store_result ($stmt);
		if(!$result) die ('Ошибка обращения к базе');
		else {
            if (mysqli_stmt_num_rows($stmt) == 0 ) return FALSE;
            else return TRUE;
        }
        mysqli_stmt_close ($stmt);
    }

    static function chekPass ($link, $login, $pass) {
        $query = "SELECT pass FROM users WHERE name = ?";
        $stmt = mysqli_prepare ($link, $query);
        mysqli_stmt_bind_param ($stmt, "s", $login);
        $result = mysqli_stmt_execute ($stmt);
		if(!$result)
            die ('Ошибка обращения к базе');
		else {
            $end = mysqli_stmt_get_result ($stmt);
            $row = mysqli_fetch_array ($end, MYSQLI_ASSOC);
            if ($row['pass'] == $pass)
                return TRUE;
            else return FALSE;
        }
        mysqli_stmt_close ($stmt);
    }

    static function addTask ($link, $name, $mail, $text) {
        $valid = '<span style="color:red">not complete</span>';
        $edit = '';
        $query = "INSERT INTO tasks(name, mail, texttask, valid, edit) VALUES(?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare ($link, $query);
        mysqli_stmt_bind_param ($stmt, "sssss", $name, $mail, $text, $valid, $edit);
        $result = mysqli_stmt_execute ($stmt);
		if(!$result)
            die ('Ошибка обращения к базе');
		else $_SESSION['addtask_success'] = 'Task added';
        mysqli_stmt_close ($stmt);
    }

    static function completeTask ($link, $id) {
        $valid = '<span style="color:green">Completed</span>';
        $query = "UPDATE tasks SET valid = ? WHERE ID = ?";
        $stmt = mysqli_prepare ($link, $query);
        mysqli_stmt_bind_param ($stmt, "ss", $valid, $id);
        $result = mysqli_stmt_execute ($stmt);
		if(!$result)
            die ('Ошибка обращения к базе');
        mysqli_stmt_close ($stmt);
    }
    static function updateTask ($link, $id, $what_past) {
        $edit = '<span style="color:green">Edited by admin, </span>';
        $query = "UPDATE tasks SET texttask = ? WHERE ID = ?";
        $stmt = mysqli_prepare ($link, $query);
        mysqli_stmt_bind_param ($stmt, "ss", $what_past, $id);
        $result = mysqli_stmt_execute ($stmt);
		if(!$result)
            die ('Ошибка обращения к базе');
        $query = "UPDATE tasks SET edit = ? WHERE ID = ?";
        $stmt = mysqli_prepare ($link, $query);
        mysqli_stmt_bind_param ($stmt, "ss", $edit, $id);
        $result = mysqli_stmt_execute ($stmt);
		if(!$result)
            die ('Ошибка обращения к базе');
        mysqli_stmt_close ($stmt);
    }
}
?>
