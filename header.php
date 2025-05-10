<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doggesh - Premium Pet Supplies</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="E-commerce.css">
</head>
<body>
  <!-- Navbar -->
  <nav>
    <div class="container">
      <div class="navbar">
        <!-- Logo -->
        <a href="#" class="logo">
          <img src="images/logo2.png" alt="Doggesh Logo" class="logo-img">
          <span class="logo-text">Doggesh</span>
        </a>

        <!-- Navigation Links - Replace this section -->
        <ul class="nav-links">
          <li><a href="#">Home</a></li>

          <!-- Products Dropdown -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle">Products <i class="fas fa-chevron-down dropdown-icon"></i></a>
            <ul class="dropdown-menu">
              <li><a href="#">Dog Food & Nutrition</a></li>
              <li><a href="#">Dog Accessories</a></li>
              <li><a href="#">Dog Toys</a></li>
              <li><a href="#">Dog Health</a></li>
              <li><a href="#">Dog Beds & Comfort</a></li>
              <li><a href="#">Tech & Gadgets</a></li>
            </ul>
          </li>

          <li><a href="#">About Us</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">Calculator</a></li>
          <li><a href="#">Contact</a></li>
        </ul>

        <div class="nav-icons">
          <i class="fas fa-search"></i>
          <i class="fas fa-shopping-cart"></i>
          <i class="fas fa-user"></i>
          <div class="mobile-menu-btn">
            <i class="fas fa-bars"></i>
          </div>
        </div>
        <div class="search-container">
          <div class="search-box">
            <input type="text" placeholder="Search for products...">
            <button class="search-btn"><i class="fas fa-search"></i></button>
            <button class="close-search"><i class="fas fa-times"></i></button>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="nav-icons">
  <?php if(isset($_SESSION['user_id'])): ?>
    <a href="profile.php"><i class="fas fa-user"></i></a>
    <?php if($_SESSION['role'] === 'admin'): ?>
      <a href="admin/"><i class="fas fa-cog"></i></a>
    <?php endif; ?>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
  <?php else: ?>
    <a href="login.php"><i class="fas fa-sign-in-alt"></i></a>
  <?php endif; ?>
  <!-- Other icons -->
</div>