<? php 
//creates connection to database

$dbServername = "localhost"; //name of server we are currently running on, find out godaddy's server name 39:30 video time
$dbUsername = "guitar_shop_app"; //database username
$dbPassword = "Admin1@345"; //database password
$dbName = "my_guitar_shop_app"; //database name

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);