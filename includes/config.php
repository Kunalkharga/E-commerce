<?php
define('DB_HOST', getenv('DB_HOST'));         // sql.freesqldatabase.com
define('DB_USER', getenv('DB_USER'));         // your generated username
define('DB_PASS', getenv('DB_PASS'));         // your generated password
define('DB_NAME', getenv('DB_NAME'));         // your generated db name

define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost/doggy-ecommerce/');
?>
