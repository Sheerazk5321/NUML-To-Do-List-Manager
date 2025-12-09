<?php
session_start();
include 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
// Fetch tasks
$query = "SELECT * FROM tasks WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>NUML To-Do Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    
    <a href="mobile_add.php" id="mobileAddBtn" class="fab-btn" style="text-decoration:none; display:flex; justify-content:center; align-items:center;">+</a>
    <?php include 'includes/header.php'; ?>

    <button id="mobileAddBtn" class="fab-btn">+</button>

    <div class="dashboard-container">
        
        <aside id="taskFormPanel" class="form-panel">
            <div class="panel-header">
                <h3>Add New Task</h3>
                <button id="closeMobileForm" class="close-btn">&times;</button>
            </div>
            
            <form action="actions/add_task.php" method="POST" class="styled-form">
                <label>What to do?</label>
                <input type="text" name="task_title" placeholder="Enter Task Title..." required>
                
                <label>Description</label>
                <textarea name="task_desc" placeholder="Add details (optional)" rows="4"></textarea>
                
                <label>Due Date</label>
                <div class="date-input-group">
                    <input type="date" name="due_date">
                    <button type="submit" name="add_task" class="btn-primary">Add Task</button>
                </div>
            </form>
        </aside>

        <main class="list-panel">
            
            <div class="controls-bar">
                <input type="text" id="searchInput" placeholder="🔍 Search tasks..." onkeyup="filterTasks()">
                
                <select id="statusFilter" onchange="filterTasks()">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="table-responsive">
                <table class="task-table" id="taskTable">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)">Title ↕</th>
                            <th onclick="sortTable(1)">Due Date ↕</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr class="task-row <?php echo $row['status']; ?>" data-status="<?php echo $row['status']; ?>">
                                    <td>
                                        <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                                        <div class="hidden-desc" style="display:none;"><?php echo htmlspecialchars($row['description']); ?></div>
                                    </td>
                                    <td>
                                        <?php echo $row['due_date'] ? date("M j, Y", strtotime($row['due_date'])) : '<span style="color:#ccc">--</span>'; ?>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></span>
                                    </td>
                                    <td class="action-cells">
                                        <button class="btn-sm btn-view" onclick="openDescModal('<?php echo htmlspecialchars(addslashes($row['title'])); ?>', this)">View 👁️</button>
                                        
                                        <?php if ($row['status'] == 'pending'): ?>
                                            <a href="actions/update_task.php?id=<?php echo $row['id']; ?>&status=completed" class="btn-sm btn-check">✅</a>
                                        <?php else: ?>
                                            <a href="actions/update_task.php?id=<?php echo $row['id']; ?>&status=pending" class="btn-sm btn-undo">↩️</a>
                                        <?php endif; ?>
                                        
                                        <a href="actions/delete_task.php?id=<?php echo $row['id']; ?>" class="btn-sm btn-del" onclick="return confirm('Delete?')">🗑️</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4" style="text-align:center;">No tasks found. Add one!</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div id="descModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeDescModal()">&times;</span>
            <h3 id="modalTitle" style="color: var(--numl-navy);"></h3>
            <hr>
            <p id="modalDesc" style="white-space: pre-wrap; margin-top: 15px; color: #555;"></p>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src="js/script.js"></script> 
</body>
</html>