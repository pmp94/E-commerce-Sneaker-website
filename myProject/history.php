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
<?php 
$cartOutput = "";
$datas = array();
$db = new PDO($connection_string, $dbuser, $dbpass);
      $stmt = $db->prepare("SELECT * from `history` where User_id='" . $_SESSION['id'] . "'");
      $stmt->execute();
       while(($data = $stmt->fetch()) !== false) {
             $datas[] = $data;        
       }
if($data['User_id'] == ""){
 $cartOutput = "<h2 align='center'>Your have no History</h2>";
}
else{
$i=0;
foreach($datas as $data){ 
$cartOutput .= "<tr>";
$cartOutput .= '<td><a>' .$data['original_name'] . '</a><br /><img src="images/' . $data['product_name'] . '.jpeg" alt="' . $data['original_name']. '" width="300" height="250" border="1" /></td>';
$cartOutput .= '<td>' . $data['quantity'] . '</td>';
$cartOutput .= '<td>$' . $data['price'] . '</td>';
$cartOutput .= '<td>' . $data['date_added']. '</td>';
$cartOutput .= '</tr>';
$i++ ;
}
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
<div class="topnav">
  <a href="home.php">Home</a>
  <a href="account.php">Account</a>
  <a href="search.php">Search</a>
  <a href="yourorder.php">Your Order</a>
  <a class="active" href="history.php">Order History</a>
</div>
 <div style="padding-left:16px">
<div align="center" id="mainWrapper">
  
  <div id="pageContent">
    <div style="margin:24px; text-align:left;">
  
    <br />
    <table width="100%" border="1" cellspacing="0" cellpadding="6">
      <tr>
        <td width="18%" bgcolor="#C5DFFA"><strong>Product</strong></td>
        <td width="10%" bgcolor="#C5DFFA"><strong>Quantity</strong></td>
        <td width="9%" bgcolor="#C5DFFA"><strong>Total Price</strong></td>
        <td width="9%" bgcolor="#C5DFFA"><strong>Date</strong></td>
      </tr>
     <?php echo $cartOutput; ?>
     <!-- <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr> -->
    </table>
    </div>
   <br />
  </div> 
</div>
</div>
</body>
</html>
