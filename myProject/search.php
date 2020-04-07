<?php
require("config.php");
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
<?php
$db = new PDO($conn, $dbuser, $dbpass);
$stmt = $db->prepare("SELECT id from `Users3` ");
$result = $stmt->fetch(PDO::FETCH_ASSOC);
		echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
		$id = $result['id'];
                echo $id;


?>
