<?php include 'header.php'; ?>

<div class="container">
    <?php if(isset($_SESSION['error'])): ?>
  <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
  <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
  <h2>Login</h2>
  <form action="auth.php" method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
  </form>
  <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

<?php include 'footer.php'; ?>