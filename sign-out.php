<?php
session_start();
unset($_SESSION['userid']);
unset($_SESSION['username']);
unset($_SESSION['role']);
header('Location:sign-in.php');
?>

