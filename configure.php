<?PHP
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'password');
define('DBASE','arms');
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
?>