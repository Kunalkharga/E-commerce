<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Doggy - Premium Pet Supplies'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="container">
            <div class="navbar">
                <a href="/index.php" class="logo">
                    <img src="/assets/images/logo2.png" alt="Doggy Logo" class="logo-img">
                    <span class="logo-text">Doggy</span>
                </a>
                <ul class="nav-links">
                    <li><a href="/index.php">Home</a></li>
                    <!-- Products Dropdown -->
                    <li class="dropdown">
                        <a href="/products/index.php" class="dropdown-toggle">Products <i
                                class="fas fa-chevron-down dropdown-icon"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="/products/food-nutrition.php">Food & Nutrition</a></li>
                            <li><a href="/products/accessories.php">Dog Accessories</a></li>
                            <li><a href="/products/health.php">Dog Health</a></li>
                        </ul>
                    </li>

                    <li><a href="/about.php">About Us</a></li>
                    <li><a href="/blog.php">Blog</a></li>
                    <li><a href="/calculator.php">Calculator</a></li>
                    <li><a href="/contact.php">Contact</a></li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="/user/profile.php">My Account</a></li>
                        <li><a href="/user/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/user/login.php">Login</a></li>
                        <li><a href="/user/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>

                <div class="search-container">
                    <div class="search-box">
                        <input type="text" placeholder="Search for products...">
                        <button class="search-btn"><i class="fas fa-search"></i></button>
                    </div>
                </div>

                <div class="nav-icons">
                    <a href="/cart.php"><i class="fas fa-shopping-cart"></i></a>
                    <i class="fas fa-user"></i>
                    <div class="mobile-menu-btn">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>