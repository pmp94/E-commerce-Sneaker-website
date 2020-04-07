<?php
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
// Check connection
if ($connection_string->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
<?php
$db = new PDO($connection_string, $dbuser, $dbpass);
$stmt = $db->prepare('SELECT id, product_name from `Products` where original_name =?');
$stmt->execute(
array(
'Nike air 50'
)
);
while(($data = $stmt->fetch()) !== false) {
echo htmlspecialchars($data['id']);
    
}
?>
