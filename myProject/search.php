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
$stmt = $db->prepare("SELECT id from `Users3` ");
$result = $stmt->fetch(PDO::FETCH_ASSOC);
		// "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
		$id = $result['id'];
                echo $id;


?>
