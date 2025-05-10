<?php include 'header.php'; ?>

<div class="container">
    <?php if(isset($_SESSION['error'])): ?>
  <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
  <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
  <h2>Register</h2>
  <form action="auth.php" method="post">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="register">Register</button>
  </form>
  <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

<?php include 'footer.php'; ?>