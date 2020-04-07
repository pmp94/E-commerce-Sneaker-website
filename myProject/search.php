<?php
require("config.php");
$conn = new mysqli($dbhost, $dbuser, $dbpass);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
<?php
$sql = mysql_query("SELECT * FROM Products");
$productCount = mysql_num_rows($sql); // count the output amount
if ($productCount > 0) {
echo "true";
}else echo "false";
?>
