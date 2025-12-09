<?php
session_start();
include '../config/database.php';

if (isset($_POST['add_task'])) {
    $title = trim($_POST['task_title']);
    $desc = trim($_POST['task_desc']); // NEW: Get Description
    $due_date = $_POST['due_date'];
    $user_id = $_SESSION['user_id'];

    if (!empty($title)) {
        if (empty($due_date)) $due_date = NULL;
        if (empty($desc)) $desc = NULL; // Handle empty description

        // Updated SQL to include description
        $query = "INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)";
        
        if ($stmt = mysqli_prepare($conn, $query)) {
            // "isss" = integer, string, string, string
            mysqli_stmt_bind_param($stmt, "isss", $user_id, $title, $desc, $due_date);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}
header("Location: ../index.php");
exit();
?>