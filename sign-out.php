<?php
session_start();
unset($_SESSION['username']);
header('Location:sign-in.php');
?>

