<?php
session_start ();
unset ($_SESSION['name']);
unset ($_SESSION['sucsess']);
session_destroy ();
header('Location: ../');
?>
