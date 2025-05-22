<?php
require_once '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<?php include '../includes/header.php'; ?>
<div class="container">
    <h2>User Profile</h2>
    <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <a href="logout.php" class="btn">Logout</a>
</div>
<?php include '../includes/footer.php'; ?>