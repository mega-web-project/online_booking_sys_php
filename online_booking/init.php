<?php
session_start();
include 'config.php';
define('HOST', $host);
define('USER', $username);
define('PASSWORD', $password);
define('DATABASE', $database);
require 'class/Database.php';
require 'class/Department.php';
require 'class/User.php';
require 'class/Menu.php';
require 'class/Request.php';
require 'class/Employee.php';
$database = new Database($host, $username, $password, $database);
$department = new Department($database);
$user =new User($database);
$menu =new Menu($database);
$request =new Request($database);
$employee =new Employee($database);


?>
