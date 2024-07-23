<?php



define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'communitydb');
require_once ('stripe-php-master/init.php');


define("PUBLISHABLE_KEY","pk_test_51O8HbLFTDSbe4ToLevcE1XCtE9Ll2LEoZQU6qVZUuowcBAf51UCnQvU8HOxr4SGz6IAn0kzK0f1VQ6rxeJLIVJ2g00jOSv8Srk");
define("SECRET_KEY","sk_test_51O8HbLFTDSbe4ToLHP0dRveZQ6VvH5IVAQs0Tgz1fmKzOIP1D0bw9PYT8nlxQqNNIsX1iLZGnq9ogAMDyf61cO2v002dyOrJ9I");

\Stripe\Stripe::setApiKey(SECRET_KEY);