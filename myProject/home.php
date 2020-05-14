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
<div class="topnav">
  <a class="active" href="home.php">Home</a>
  <a href="account.php">Account</a>
  <a href="search.php">Search</a>
  <a href="yourorder.php">Your Order</a>
  <a href="history.php">Order History</a>
</div>

<div style="padding-left:16px">
  <h2>Latest resease</h2>
</div>

<style>
* {
  box-sizing: border-box;
}

body {
  margin: 0;
}


.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.price {
  color: grey;
  font-size: 22px;
}

.card button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

.card button:hover {
  opacity: 0.7;
}


.column {
  float: left;
  width: 33.33%;
  padding: 15px;
}


.row:after {
  content: "";
  display: table;
  clear: both;
}


@media screen and (max-width:600px) {
  .column {
    width: 100%;
  }
}
</style>
</head>
<body>
<div class="row">
  <?php 
$cartOutput = "";
$datas = array();
$db = new PDO($connection_string, $dbuser, $dbpass);
      $stm = $db->prepare("SELECT * from `latest_release` ");
      $stm->execute();
       while(($dat = $stm->fetch()) !== false) {
             $datas[] = $dat;        
       }
$i=0;
foreach($datas as $dat){ 
$n= $dat['name'];
$stmt = $db->prepare("SELECT * from `Products` WHERE original_name = '$n' ");
      $stmt->execute();
while(($data = $stmt->fetch()) !== false) {
$img = $data['product_name'];
$name = $data['original_name'];
$price = $data['price'];
$id = $data['id']; 
echo '<div class="column">';
echo '<div class="card">';
echo '<form action="yourorder.php?pid='.$id.'"  method="POST">';
echo '<img src="images/'.$img.'.jpeg" style="width:300px;height:250px" style="width:100%">';
echo '<h1 id="1">'.$name.'</h1>';
echo '<p class="price">$'.$price.'</p>';
echo '<p><button name="1">Add to Cart</button></p>';
echo '</form></div></div>';
}
$i++ ;
}
?>
</div>
<div style="padding-left:16px">
  <h2>You may also like</h2>
</div>

<div class="row">
  <div class="column">
        <div class="card">
          <form action="yourorder.php?pid=3" method="POST">
            <img src="images/nike3.jpeg" style="width:300px;height:250px" style="width:100%">
            <h1 id="3">Nike air 150</h1>
            <p class="price">$149.99</p>
            <p><button name="3">Add to Cart</button></p>
            </form>
        </div>
  </div>
 <div class="column">
    <div class="card">
      <form action="yourorder.php?pid=25" method="POST">
      <img src="images/vans5.jpeg" style="width:300px;height:250px" style="width:100%">
      <h1 id="5">Los Vans Old Skool</h1>
      <p class="price">$90</p>
      <p><button name="4">Add to Cart</button></p>
      </form>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <form action="yourorder.php?pid=30" method="POST">
      <img src="images/sk5.jpeg" style="width:300px;height:250px" style="width:100%" >
      <h1 id="7">MOREWAY-BARCO</h1>
      <p class="price">$110</p>
      <p><button name="7">Add to Cart</button></p>
      </form>
    </div>
  </div>
</div>


</body>

</body>
</html>

