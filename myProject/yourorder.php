<?php
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("config.php");
$conn = new mysqli($dbhost, $dbuser, $dbpass);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

<?php

if (isset($_GET['idp'])) {

    echo 'bye';
    
    $sql ="SELECT id FROM Products";
if ($result = $conn->query($sql)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        echo "true";
    }
}
}else{
    echo "fales";
}

/* close connection */
$conn->close();

      
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
  <a href="home.html">Home</a>
  <a href="account.html">Account</a>
  <a href="search.html">Search</a>
  <a class="active" href="your order.html">Your Order</a>
  
</div>

<div style="padding-left:16px">
  <h2>Responsive Search Bar</h2>
  <p>Navigation bar with a search box inside of it.</p>
  <p>Resize the browser window to see the responsive effect.</p>
  <p>For more examples on how to add a submit button and icon inside the search bar, go back to the tutorial.</p>
</div>

</body>
</html>


