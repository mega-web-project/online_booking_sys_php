<?php
include 'init.php';
include('inc/formsheader.php');



// Create a new User instance
$user = new User($database);

// Logout the user
$user->logout();

// Redirect to the login page or any other page after logout
header('Location: login.php');
exit();
?>
