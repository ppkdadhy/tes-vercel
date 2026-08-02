<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "project_crud3";

// // Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);

// // Check connection
// if (!$conn) {
//   die("Connection failed: " . mysqli_connect_error());
// }
// echo "Connected successfully";

// Atur keamanan session cookie sebelum session_start
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_only_cookies', 1);
    ini_set('session.use_strict_mode', 1);
    
    session_set_cookie_params([
        'lifetime' => 86400, // 1 hari
        'path' => '/',
        'secure' => true,    // Wajib true di Vercel (HTTPS)
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    
    session_start();
}


$servername = getenv('DB_HOST') ?: "localhost";
$username   = getenv('DB_USER') ?: "root";
$password   = getenv('DB_PASS') ?: "";
$dbname     = getenv('DB_NAME') ?: "project_crud3";
$port       = getenv('DB_PORT') ?: 3306;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>