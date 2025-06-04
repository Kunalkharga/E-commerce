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
<div class="auth-container">
    <div class="auth-profile-card">
        <div class="auth-profile-header">
            <div class="auth-profile-image">
                <?php
                $image_path = realpath(dirname(__FILE__) . '/..') . '/assets/images/profile/' . ($user['profile_image'] ?? '');
                if ($user['profile_image'] && file_exists($image_path)): ?>
                    <img src="<?php echo BASE_URL; ?>assets/images/profile/<?php echo htmlspecialchars($user['profile_image']); ?>?t=<?php echo time(); ?>"
                        alt="Profile" class="auth-profile-img">
                <?php else: ?>
                    <i class="fas fa-user-circle"></i>
                <?php endif; ?>
            </div>
            <h2 class="auth-profile-name"><?php echo htmlspecialchars($user['username']); ?></h2>
        </div>
        <div class="auth-profile-details">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <?php if (isset($user['phone']) && !empty($user['phone'])): ?>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <?php endif; ?>
            <div class="auth-profile-actions">
                <a href="edit_profile.php" class="auth-btn">Edit Profile</a>
                <a href="logout.php" class="auth-btn auth-btn-logout">Logout</a>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>