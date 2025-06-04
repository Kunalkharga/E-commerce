<?php
require_once '../includes/db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        $_SESSION['user_id'] = $pdo->lastInsertId();
        header("Location: ../index.php");
        exit;
    } catch (PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
?>

<?php include '../includes/header.php'; ?>
<div class="auth-container">
    <h2>Register</h2>
    <?php if (isset($error)): ?>
        <p class="auth-error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" class="auth-form">
        <div class="auth-form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="auth-form-control" required>
        </div>
        <div class="auth-form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="auth-form-control" required>
        </div>
        <div class="auth-form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="auth-form-control" required>
        </div>
        <button type="submit" class="auth-btn-submit">Register</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>