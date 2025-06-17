<?php
require_once 'config.php';
// session_start();

// Calculate total items in cart
$cart_count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doggy - Pet Store</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/e-commerce.css">
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <nav>
        <div class="container">
            <div class="navbar">
                <!-- Logo (left side) -->
                <a href="<?php echo BASE_URL; ?>index.php" class="logo">
                    <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt="Doggy Logo" class="logo-img">
                    <span class="logo-text">Doggy</span>
                </a>

                <!-- Desktop Navigation -->
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
                    <div class="search-container">
                        <div class="search-box">
                            <input type="text" placeholder="Search for products...">
                            <button class="search-btn"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="nav-icons">
                        <a href="<?php echo BASE_URL; ?>cart.php" class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <?php if ($cart_count > 0): ?>
                                <span class="cart-count"><?php echo $cart_count; ?></span>
                            <?php endif; ?>
                        </a>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="<?php echo BASE_URL; ?>user/profile.php"><i class="fas fa-user"></i></a></li>
                            <li><a href="<?php echo BASE_URL; ?>user/logout.php"><i class="fas fa-sign-out-alt"></i></a>
                            </li>
                        <?php else: ?>
                        </div>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle nav-icons">
                                <i class="fas fa-user"></i>
                                <i class="fas fa-chevron-down dropdown-icon" style="display: none;"></i>
                            </a>
                            <ul class="dropdown-menu" style="right: 0; left: auto; min-width: 120px;">
                                <li><a href="<?php echo BASE_URL; ?>user/login.php">Login</a></li>
                                <li><a href="<?php echo BASE_URL; ?>user/register.php">Register</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Mobile Icons and Menu Button (right side) -->
                <div class="mobile-icons">
                    <a href="<?php echo BASE_URL; ?>cart.php" class="mobile-icon cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if ($cart_count > 0): ?>
                            <span class="cart-count"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    </a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo BASE_URL; ?>user/profile.php" class="mobile-icon">
                            <i class="fas fa-user"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>user/login.php" class="mobile-icon">
                            <i class="fas fa-user"></i>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </nav>