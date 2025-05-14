<?php include 'includes/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <!-- Existing head content -->
</head>
<body>
    <!-- Existing navbar -->
    <div class="container">
        <h2>Login</h2>
        <form action="includes/login_handler.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>