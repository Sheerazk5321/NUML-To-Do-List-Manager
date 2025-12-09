<?php
session_start();
include '../config/database.php';

// Check if ID and Status are set in the URL
if (isset($_GET['id']) && isset($_GET['status'])) {
    
    $task_id = $_GET['id'];
    $status = $_GET['status'];
    $user_id = $_SESSION['user_id'];

    // Validate status to prevent bad data
    if ($status !== 'pending' && $status !== 'completed') {
        header("Location: ../index.php");
        exit();
    }

    // Update Query
    // IMPORTANT: We check 'AND user_id = ?' so users can't update others' tasks!
    $query = "UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        // s = string (status), i = integer (task_id), i = integer (user_id)
        mysqli_stmt_bind_param($stmt, "sii", $status, $task_id, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Redirect back to dashboard
header("Location: ../index.php");
exit();
?>