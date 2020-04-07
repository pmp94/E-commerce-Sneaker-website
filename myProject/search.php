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
mysql_select_db("pmp94", $con);
$query = "SELECT * FROM `Users3`";
$comments = mysql_query($query);
echo "<h1>User Comments</h1>";
while($row = mysql_fetch_assoc($comments, MYSQL_ASSOC))
{
    echo "true";
    }

?>
