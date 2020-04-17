<?php
session_start();
if (!isset($_SESSION['id'])) {
 header("location:login.php"); 
    exit();
}
?>
<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
?>

<?php 
$db = new PDO($connection_string, $dbuser, $dbpass);
$stmt = $db->prepare("SELECT * from `Users3` where id = $_SESSION['id'] LIMIT 1");
$stmt->execute();
      while(($data = $stmt->fetch()) !== false) {
                $user_name = htmlspecialchars($data['Name']) ;  
                $user_email= htmlspecialchars($data['email']) ; 
                $user_phone_number= htmlspecialchars($data['PhoneNumber']) ;
     
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box;}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #e9e9e9;
}

.topnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #2196F3;
  color: white;
}

.topnav input[type=text] {
  float: right;
  padding: 6px;
  margin-top: 8px;
  margin-right: 16px;
  border: none;
  font-size: 17px;
}

@media screen and (max-width: 600px) {
  .topnav a, .topnav input[type=text] {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  
  .topnav input[type=text] {
    border: 1px solid #ccc;  
  }
}
</style>
</head>
<body>
<center><h1> Weclom to Flipcart</h1></center>
<div class="topnav">
  <a href="home.php">Home</a>
  <a class="active" href="account.php">Account</a>
  <a href="search.php">Search</a>
  <a href="yourorder.php">Your Order</a>
  
</div>

<div style="padding-left:16px">
  <div class = "jumbotron">
    <h1> User Detail</h1>
  </div>
   <div class = "row">
    <strong class = "column">Name</strong> 
    <div class = "column"><?php echo "$user_name";?></div>
 </div>
   <div class = "row">
    <strong class = "column">Email</strong> 
    <div class = "column"><?php echo "$user_email";?></div>
 </div>
   <div class = "row">
    <strong class = "column">Phone number</strong> 
    <div class = "column"><?php echo "$user_phone_number";?></div>
 </div>
</div>

</body>
</html>

