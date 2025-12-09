<?php
session_start();
// 1. Security: Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task - Mobile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Mobile Specific Styles for this page */
        body { background-color: var(--bg-light); }
        
        .mobile-container {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Re-use the pro form styles but make them full width */
        .mobile-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border-top: 6px solid var(--numl-navy);
        }

        .page-title {
            color: var(--numl-navy);
            margin-bottom: 20px;
            font-size: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-link {
            font-size: 0.9rem;
            color: #777;
            text-decoration: none;
            background: #eee;
            padding: 5px 12px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="mobile-container">
        <div class="mobile-card">
            <div class="page-title">
                <span>Add New Task</span>
                <a href="index.php" class="back-link">Cancel ✕</a>
            </div>

            <form action="actions/add_task.php" method="POST" class="styled-form">
                
                <label>What to do?</label>
                <input type="text" name="task_title" placeholder="Enter Task Title..." required autofocus>
                
                <label>Description</label>
                <textarea name="task_desc" placeholder="Add details (optional)" rows="5"></textarea>
                
                <label>Due Date</label>
                <input type="date" name="due_date" style="margin-bottom: 20px;">

                <button type="submit" name="add_task" class="btn-primary" style="padding: 15px; font-size: 1.1rem;">
                    Save Task
                </button>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>