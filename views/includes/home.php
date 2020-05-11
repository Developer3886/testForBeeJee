<?php defined ('_ACCESS') or die (); ?>

<div class="col-12 mr-6 ml-6 wow fadeIn" data-wow-duration="2s">
    <div class="text-center white-block">
        <h1>Welcome to Bee Jee test :-)</h1>
    </div>
</div>

<?php
    if ($_SESSION['success'] && $_SESSION['name']) {
    echo "<div class='loigin-sucsses col-12 pl-3 pr-3 alert alert-success'>";
    echo "Welcome, ".$_SESSION['name']." <a href='/controls/logoutController.php' class='btn btn-primary btn-sm float-right'>Log out</a>";
    echo "</div>";
}
?>

<div class="col-3">
    <div class="text-center white-block wow slideInLeft">
        <h6 class="text-muted">Admin join</h6>
        <?php
            if($_SESSION['errors']) {
                echo "<div class='alert alert-danger'>";
                echo "<ul>";
                foreach ($_SESSION['errors'] as $v) {
                    echo "<li>";
                    echo $v;
                    echo "</li>";
                }
                echo "<ul>";
                echo "</div>";
                unset ($_SESSION['errors']);
            }
        ?>
        <form class="px-3 py-2" method="post" action="/controls/AdminjoinController.php" novalidate>
            <div class="form-group">
                <label for="user_login">Login</label>
                <input type="text" name="user_login" class="form-control" id="user_login" placeholder="your login here, please...">
            </div>
            <div class="form-group">
                <label for="user_pass">Password</label>
                <input type="password" name="user_pass" class="form-control" id="user_pass" placeholder="your password here, please...">
            </div><br />
            <button type="submit" class="btn btn-primary btn-sm w-100">Login</button>
        </form>
    </div>
</div>

<div class="col-6">
    <div class="text-center white-block wow slideInUp">
        <h6 class="text-muted">Task list</h6>
        <form class="px-3 py-2" method="post" action="/controls/sortController.php" novalidate>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="sortby" class="col-form-label">Sort by</label>
                </div>
                <div class="form-group col-md-6">
                    <select id="sortby" name="how_sort" class="form-control">
                        <option value="name_asc" selected>name ascending</option>
                        <option value="name_desc">name descending</option>
                        <option value="mail_asc">e-mail ascending</option>
                        <option value="mail_desc">e-mail descending</option>
                        <option value="status_completed">status ascending</option>
                        <option value="status_not_comlete">status descending</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <button type="submit" class="btn btn-primary btn-sm w-100">Sort</button>
                </div>
            </div>
        </form>


        <?php
            if ($_SESSION['addtask_success']) {
                echo "<div class='alert alert-success'>";
                echo $_SESSION['addtask_success'];
                echo "</div>";
                unset ($_SESSION['addtask_success']);
            }
            require __DIR__.'/../../models/connect.php';
            $link = Connects::connectDB ();
            $query = "SELECT ID, name, mail, texttask, valid, edit FROM tasks ORDER BY ID DESC";
            $result = mysqli_query ($link, $query);
            $records = mysqli_fetch_row ($result);
            $total_rows = $records[0];
            $per_page = 3;
            $num_pages = ceil ($total_rows / $per_page);
            if (isset ($_GET['page']))
                $page = ($_GET['page'] - 1);
            else $page=0;
            $start = abs ($page * $per_page);
            if ($_SESSION['sortBy']) {
                $q = $_SESSION['query'];
                unset ($_SESSION['sortBy']);
                unset ($_SESSION['query']);
            }
            else $q = "SELECT ID, name, mail, texttask, valid, edit FROM `tasks` ORDER BY ID DESC LIMIT $start, $per_page";
            $res = mysqli_query ($link, $q) ;
            if(!$res)
                die ('Ошибка обращения к базе');
    		else {
                while($row = mysqli_fetch_assoc($res)){
                    echo <<<MSG
                    <div class="row">
                        <div class="col-12 text-left alert alert-secondary">
                            <span class="text-muted">Created:</span> {$row['name']}
                            <span class="text-muted">Email:</span> {$row['mail']}
                            <div class="float-right">
                                <span class="text-muted">Status: </span>
                                {$row['edit']}
                                {$row['valid']}
                            </div><br /><br />
MSG;
                            if ($_SESSION['success']) {
                                echo "<a href='/controls/completeTaskController.php?id={$row['ID']}'><button class='btn btn-primary btn-sm float-right complete'>Complete</button></a>";
                                echo "<a href='/?id={$row['ID']}'><span class='float-right'><button class='btn btn-primary btn-sm complete'>Edit</button>&nbsp;</span></a>";
                            }
                    echo <<<MSG
                            <hr />
                            <span class="text-muted">Task:</span><br />
                            {$row['texttask']}
                        </div>
                    </div>
MSG;
                }
            }
            for ($i=1; $i<=$num_pages; $i++) {
                if ($i-1 == $page) {
                    echo $i." ";
                } else {
                echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i."</a> ";
                }
            }
        ?>

    </div>
</div>

<div class="col-3">
    <div class="text-center white-block wow slideInRight">
        <h6 class="text-muted">Add task</h6>
        <?php
            if ($_SESSION['errors_addtask']) {
                echo "<div class='alert alert-danger'>";
                echo "<ul>";
                foreach ($_SESSION['errors_addtask'] as $v) {
                    echo "<li>";
                    echo $v;
                    echo "</li>";
                }
                echo "<ul>";
                echo "</div>";
                unset ($_SESSION['errors_addtask']);
            }
        ?>
        <form class="px-3 py-2" method="post" action="/controls/addtaskController.php" novalidate>
            <div class="form-group">
                <label for="user_name">Name</label>
                <input type="text" name="user_name" class="form-control" id="user_name">
            </div>
            <div class="form-group">
                <label for="user_mail">E-mail</label>
                <input type="text" name="user_mail" class="form-control" id="user_mail">
            </div>
            <div class="form-group">
                <label for="task_text">Task text</label>
                <textarea name="task_text" class="form-control" id="task_text"></textarea>
            </div><br />
            <button type="submit" class="btn btn-primary btn-sm w-100">Create task</button>
        </form>
    </div>
</div>
