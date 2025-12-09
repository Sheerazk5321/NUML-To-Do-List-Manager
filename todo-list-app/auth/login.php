<?php
session_start();
// Fix paths since we are inside the 'auth' folder
include '../config/database.php';

$message = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: ../index.php");
            exit();
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - NUML To-Do</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Special override just for Auth pages to center content */
        body.auth-page {
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Pushes footer down */
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
                <h2>Welcome Back! 👋</h2>
                <p>Login to manage your tasks</p>
            </div>
            
            <?php if ($message): ?>
                <div class="error-msg"><?php echo $message; ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="styled-form">
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter your ID" required>
                </div>
                
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" name="login" class="btn-primary auth-btn-lg">Login Now</button>
            </form>

            <div class="auth-footer">
                Don't have an account? <a href="register.php">Create Account</a>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

</body>
</html>