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
    <div class="profile-card">
        <div class="profile-header" style="background-color: #004080; color: white; padding: 20px; border-radius: 10px 10px 0 0;">
            <div class="profile-image">
                <?php
                $image_path = realpath(dirname(__FILE__) . '/..') . '/assets/images/profile/' . ($user['profile_image'] ?? '');
                if ($user['profile_image'] && file_exists($image_path)): ?>
                    <img src="<?php echo BASE_URL; ?>assets/images/profile/<?php echo htmlspecialchars($user['profile_image']); ?>?t=<?php echo time(); ?>" alt="Profile" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                <?php else: ?>
                    <i class="fas fa-user-circle" style="font-size: 80px; color: #F9942A;"></i>
                <?php endif; ?>
            </div>
            <h2 class="profile-name"><?php echo htmlspecialchars($user['username']); ?></h2>
        </div>
        <div class="profile-details" style="background-color: white; padding: 30px; border-radius: 0 0 10px 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <?php if (isset($user['phone']) && !empty($user['phone'])): ?>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <?php endif; ?>
            <div class="profile-actions">
                <a href="edit_profile.php" class="btn" style="background-color: #F9942A; color: white; margin-right: 10px;">Edit Profile</a>
                <a href="logout.php" class="btn" style="background-color: #004080; color: white;">Logout</a>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>

<style>
.profile-card {
    max-width: 600px;
    margin: 50px auto;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.profile-header {
    text-align: center;
}

.profile-image {
    margin-bottom: 10px;
}

.profile-name {
    font-size: 24px;
    margin: 0;
}

.profile-details {
    text-align: center;
}

.profile-details p {
    font-size: 16px;
    color: #333;
    margin: 10px 0;
}

.profile-actions {
    margin-top: 20px;
}

.profile-actions .btn {
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.profile-actions .btn:hover {
    opacity: 0.9;
}

@media (max-width: 768px) {
    .profile-card {
        margin: 20px;
        width: 100%;
    }
    .profile-actions .btn {
        display: block;
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>