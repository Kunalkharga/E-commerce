<?php include 'header.php'; ?>

<div class="container">
  <h2>Login</h2>
  <form action="auth.php" method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
  </form>
  <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

<?php include 'footer.php'; ?>