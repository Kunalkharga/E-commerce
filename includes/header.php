<?php
require_once 'config.php';
// session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doggy - Pet Store</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/e-commerce.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <nav>
        <div class="container">
            <div class="navbar">
                <a href="<?php echo BASE_URL; ?>index.php" class="logo">
                    <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt="Doggy Logo" class="logo-img">
                    <span class="logo-text">Doggy</span>
                </a>
                <div class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-links">
                    <li><a href="<?php echo BASE_URL; ?>index.php">Home</a></li>
                    <li class="dropdown">
                        <a href="<?php echo BASE_URL; ?>products.php" class="dropdown-toggle">Products <i
                                class="fas fa-chevron-down dropdown-icon"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo BASE_URL; ?>food-nutrition.php">Food & Nutrition</a></li>
                            <li><a href="<?php echo BASE_URL; ?>dog-accessories.php">Dog Accessories</a></li>
                            <li><a href="<?php echo BASE_URL; ?>doghealth.php">Dog Health</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo BASE_URL; ?>aboutus.php">About Us</a></li>
                    <li><a href="<?php echo BASE_URL; ?>blog.php">Blog</a></li>
                    <li><a href="<?php echo BASE_URL; ?>calculator.php">Calculator</a></li>
                    <li><a href="<?php echo BASE_URL; ?>contact.php">Contact</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="<?php echo BASE_URL; ?>user/profile.php">Profile</a></li>
                        <li><a href="<?php echo BASE_URL; ?>user/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo BASE_URL; ?>user/login.php">Login</a></li>
                        <li><a href="<?php echo BASE_URL; ?>user/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
                <div class="search-container">
                    <div class="search-box">
                        <input type="text" placeholder="Search for products...">
                        <button class="search-btn"><i class="fas fa-search"></i></button>
                    </div>
                    
                    <div class="nav-icons">
                        <a href="#"><i class="fas fa-shopping-cart"></i></a>
                        <a href="<?php echo BASE_URL; ?>user/profile.php"><i class="fas fa-user"></i></a>
                    </div>
                </div>
            </div>
    </nav>
    </div>