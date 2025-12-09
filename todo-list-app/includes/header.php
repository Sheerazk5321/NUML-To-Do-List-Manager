<header>
    <nav>
        <div class="logo">
            <?php $path = file_exists('images/logo.png') ? 'images/logo.png' : '../images/logo.png'; ?>
            <img src="<?php echo $path; ?>" alt="NUML Logo" style="height: 40px; margin-right: 10px;">
            <!-- <img src="images/logo.png" alt="NUML Logo" style="height: 50px; margin-right: 10px;"> -->
            
            NUML To-Do
        </div>
        
        <div class="nav-links">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span>User: <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="auth/logout.php">Logout</a>
            <?php endif; ?>
        </div>
    </nav>
</header>