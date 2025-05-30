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
<div class="container">
    <div class="profile-card">
        <div class="profile-header" style="background-color: #004080; color: white; padding: 20px; border-radius: 10px 10px 0 0; text-align: center;">
            <h2>Edit Profile</h2>
        </div>
        <div class="profile-details" style="background-color: white; padding: 30px; border-radius: 0 0 10px 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
            <?php if (isset($error)): ?>
                <p style="color: #F1642C; text-align: center;"><?php echo $error; ?></p>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <p style="color: green; text-align: center;"><?php echo $success; ?></p>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data" style="max-width: 400px; margin: 0 auto;">
                <div class="form-group">
                    <label for="profile_image">Profile Image (Optional)</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*" class="form-control">
                    <?php if ($user['profile_image']): ?>
                        <p style="margin-top: 10px;">
                            Current Image: <img src="<?php echo BASE_URL; ?>assets/images/profile/<?php echo htmlspecialchars($user['profile_image']); ?>?t=<?php echo time(); ?>" alt="Profile Image" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        </p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Phone (Optional)</label>
                    <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" class="form-control">
                </div>
                <button type="submit" class="btn" style="background-color: #F9942A; color: white; width: 100%; margin-top: 20px;">Save Changes</button>
            </form>
            <div style="text-align: center; margin-top: 20px;">
                <a href="profile.php" class="btn" style="background-color: #004080; color: white;">Back to Profile</a>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>