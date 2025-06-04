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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = !empty($_POST['phone']) ? filter_var($_POST['phone'], FILTER_SANITIZE_STRING) : null;
    $profile_image = $user['profile_image'] ?? null; // Default to existing image

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        $file_type = mime_content_type($_FILES['profile_image']['tmp_name']);
        $file_size = $_FILES['profile_image']['size'];

        if (in_array($file_type, $allowed_types) && $file_size <= $max_size) {
            $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $new_filename = 'user_' . $_SESSION['user_id'] . '_' . time() . '.' . $ext;
            $upload_path = '../assets/images/profile/' . $new_filename;
            $absolute_path = realpath(dirname(__FILE__) . '/..') . '/assets/images/profile/' . $new_filename;

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $absolute_path)) {
                // Delete old image if it exists
                if ($profile_image && file_exists(realpath(dirname(__FILE__) . '/..') . '/assets/images/profile/' . $profile_image)) {
                    unlink(realpath(dirname(__FILE__) . '/..') . '/assets/images/profile/' . $profile_image);
                }
                $profile_image = $new_filename;
            } else {
                $error = "Failed to upload the image. Check directory permissions.";
            }
        } else {
            $error = "Invalid file type or size. Allowed types: JPG, PNG, GIF. Max size: 5MB.";
        }
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare("UPDATE users SET email = ?, phone = ?, profile_image = ? WHERE id = ?");
        if ($stmt->execute([$email, $phone, $profile_image, $_SESSION['user_id']])) {
            $success = "Profile updated successfully!";
            header("Location: profile.php");
            exit;
        } else {
            $error = "Failed to update profile in database.";
        }
    } else {
        $error = "Invalid email format.";
    }
}
?>

<?php include '../includes/header.php'; ?>
<div class="auth-container">
    <div class="auth-profile-card">
        <div class="auth-profile-header">
            <h2 class="auth-profile-name">Edit Profile</h2>
        </div>
        <div class="auth-profile-details">
            <?php if (isset($error)): ?>
                <p class="auth-error"><?php echo $error; ?></p>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <p class="auth-success"><?php echo $success; ?></p>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data" class="auth-form">
                <div class="auth-form-group">
                    <label for="profile_image">Profile Image (Optional)</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*" class="auth-form-control">
                    <?php if ($user['profile_image']): ?>
                        <p class="auth-current-image">
                            Current Image: <img src="<?php echo BASE_URL; ?>assets/images/profile/<?php echo htmlspecialchars($user['profile_image']); ?>?t=<?php echo time(); ?>" alt="Profile Image" class="auth-profile-img-small">
                        </p>
                    <?php endif; ?>
                </div>
                <div class="auth-form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="auth-form-control">
                </div>
                <div class="auth-form-group">
                    <label for="phone">Phone (Optional)</label>
                    <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" class="auth-form-control">
                </div>
                <button type="submit" class="auth-btn auth-btn-save">Save Changes</button>
            </form>
            <div class="auth-back-link">
                <a href="profile.php" class="auth-btn">Back to Profile</a>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>