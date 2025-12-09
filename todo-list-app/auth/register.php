<?php
session_start();
include '../config/database.php';

$message = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if user exists
    $check_query = "SELECT id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $message = "Username already taken!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: login.php");
            exit();
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - NUML To-Do</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body.auth-page {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
        }
        .auth-container {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f4f7f6 0%, #e1e5ee 100%);
            padding: 20px;
        }
    </style>
</head>
<body class="auth-page">

    <?php include '../includes/header.php'; ?>

    <div class="auth-container">
        <div class="auth-card animated-card">
            <div class="auth-header">
                <h2>Join Us! 🚀</h2>
                <p>Start organizing your university life</p>
            </div>
            
            <?php if ($message): ?>
                <div class="error-msg"><?php echo $message; ?></div>
            <?php endif; ?>

            <form action="register.php" method="POST" class="styled-form">
                <div class="input-group">
                    <label>Choose Username</label>
                    <input type="text" name="username" placeholder="e.g. Ali123" required>
                </div>
                
                <div class="input-group">
                    <label>Choose Password</label>
                    <input type="password" name="password" placeholder="Min 6 characters" required>
                </div>

                <button type="submit" name="register" class="btn-primary auth-btn-lg">Sign Up Free</button>
            </form>
            
            <div class="auth-footer">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

</body>
</html>