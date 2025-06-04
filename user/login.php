<?php
require_once '../includes/db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: ../index.php");
            exit;
        } else {
            $error = "Invalid email or password";
        }
    } catch (PDOException $e) {
        $error = "Login failed: " . $e->getMessage();
    }
}
?>

<?php include '../includes/header.php'; ?>
<div class="auth-container">
    <h2>User Login</h2>
    <?php if (isset($error)): ?>
        <p class="auth-error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" class="auth-form">
        <div class="auth-form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="auth-form-control" required>
        </div>
        <div class="auth-form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="auth-form-control" required>
        </div>
        <button type="submit" class="auth-btn-submit">Login</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>