<?php
$host = 'localhost';
$user = 'root';      // Default XAMPP/WAMP username
$pass = '';          // Default XAMPP/WAMP password (leave empty)
$db_name = 'todo_app';

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>