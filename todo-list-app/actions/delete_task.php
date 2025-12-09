<?php
session_start();
include '../config/database.php';

if (isset($_GET['id'])) {
    
    $task_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Delete Query
    // IMPORTANT: We check 'AND user_id = ?' for security
    $query = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "ii", $task_id, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Redirect back to dashboard
header("Location: ../index.php");
exit();
?>