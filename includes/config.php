<?php
// Database configuration using environment variables
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));

// Base URL for the website (you can update this after deployment)
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost/doggy-ecommerce/');
?>
