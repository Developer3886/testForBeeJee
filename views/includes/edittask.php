<?php
    defined ('_ACCESS') or die ();
    session_start ();
    require __DIR__.'/../../models/connect.php';
    $id_for_edit = htmlspecialchars(strip_tags($_GET['id']));
    $link = Connects::connectDB ();
    $query = "SELECT texttask FROM tasks WHERE ID = ?";
    $stmt = mysqli_prepare ($link, $query);
    mysqli_stmt_bind_param ($stmt, "s", $id_for_edit);
    $result = mysqli_stmt_execute ($stmt);
    if(!$result)
        die ('Ошибка обращения к базе');
    else {
        $end = mysqli_stmt_get_result ($stmt);
        $row = mysqli_fetch_array ($end, MYSQLI_ASSOC);
    }
?>
<div class="form-popup col-6 offset-3 mt-4 mb-4 wow fadeIn">
    <form class="px-3 py-2" method="post" action="/controls/editTaskController.php" novalidate>
        <div class="form-group">
            <label for="task_text_edit">Edit task text</label>
            <textarea name="task_text_edit" class="form-control" id="task_text_edit"><?= $row['texttask'] ?></textarea>
            <input type="hidden" name="id" value="<?= $id_for_edit ?>">
        </div><br />
        <button type="submit" class="btn btn-primary btn-sm w-100">Edit</button>
    </form>
</div>
