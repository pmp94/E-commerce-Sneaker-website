<?php
session_start();
if (!isset($_SESSION['id'])) {
 header("location:login.php"); 
    exit();
}
?>
<?php
session_start();
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
  <a href="home.php">Home</a>
  <a href="account.php">Account</a>
  <a class="active" href="search.php">Search</a>
  <a href="yourorder.php">Your Order</a>
  <a href="history.php">Order History</a>
</div>
</body>
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
<body> 
<div class="row">
  <div class="column">
        <div class="card">
          <form action="yourorder.php?pid=10"  method="POST">
            <img src="images/puma1.jpeg" style="width:300px;height:250px"  >
            <h1 id="1">Puma Cali</h1>
            <p class="price">$49.99</p>
            <p><button name="1">Add to Cart</button></p>
            </form>
        </div>
  </div>

  <div class="column">
    <div class="card">
      <form action="yourorder.php?pid=11"  method="POST">
      <img src="images/puma2.jpeg" style="width:300px;height:250px" >
      <h1 id="2">Puma RX-S</h1>
      <p class="price">$99.99</p>
      <p><button name="2">Add to Cart</button></p>
      </form>
    </div>
  </div>
  <div class="column">
    <div class="card">
      <form action="yourorder.php?pid=12" method="POST">
      <img src="images/puma3.jpeg" style="width:300px;height:250px" style="width:100%">
      <h1 id="6">Puma Future Rider</h1><?php?>
      <p class="price">$149.99</p>
      <p><button name="6">Add to Cart</button></p>
      </form>
    </div>
  </div>
</div>
<div style="padding-left:16px">
  <h2>You may also like</h2>
</div>

<div class="row">
  <div class="column">
        <div class="card">
          <form action="yourorder.php?pid=13" method="POST">
            <img src="images/puma4.jpeg" style="width:300px;height:250px" style="width:100%">
            <h1 id="3">Puma GV Hacked</h1>
            <p class="price">$199.99</p>
            <p><button name="3">Add to Cart</button></p>
            </form>
        </div>
  </div>
 <div class="column">
    <div class="card">
      <form action="yourorder.php?pid=14" method="POST">
      <img src="images/puma5.jpeg" style="width:300px;height:250px" style="width:100%">
      <h1 id="5">Puma Rise</h1>
      <p class="price">$249.99</p>
      <p><button name="4">Add to Cart</button></p>
      </form>
    </div>
  </div>

</body>
</html>
