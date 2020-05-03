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
if (isset($_GET['pid'])) {
  $pid = $_GET['pid'];
  $wasFound = false;
  $i = 0;
  if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
    $_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));
  } else {
    foreach ($_SESSION["cart_array"] as $each_item) { 
          $i++;
          while (list($key, $value) = each($each_item)) {
          if ($key == "item_id" && $value == $pid) {
            array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
            $wasFound = true;
          } 
          } 
         } 
       if ($wasFound == false) {
         array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
       }
  }
}
?>
<?php 
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
    unset($_SESSION["cart_array"]);
}
?>
<?php 
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
  $item_to_adjust = $_POST['item_to_adjust'];
  $quantity = $_POST['quantity'];
  $quantity = preg_replace('#[^0-9]#i', '', $quantity); 
  if ($quantity >= 100) { $quantity = 99; }
  if ($quantity < 1) { $quantity = 1; }
  if ($quantity == "") { $quantity = 1; }
  $i = 0;
  foreach ($_SESSION["cart_array"] as $each_item) { 
          $i++;
          while (list($key, $value) = each($each_item)) {
          if ($key == "item_id" && $value == $item_to_adjust) {
            array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
          } 
          } 
  }
}
?>
<?php 
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
  $key_to_remove = $_POST['index_to_remove'];
  if (count($_SESSION["cart_array"]) <= 1) {
    unset($_SESSION["cart_array"]);
  } else {
    unset($_SESSION["cart_array"]["$key_to_remove"]);
    sort($_SESSION["cart_array"]);
  }
}
?>
<?php 
$cartOutput = "";
$cartTotal = "";
$pp_checkout_btn = '';
$product_id_array = '';
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
    $cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
} else {
  $i = 0; 
    foreach ($_SESSION["cart_array"] as $each_item) { 
    $item_id = $each_item['item_id'];
      $db = new PDO($connection_string, $dbuser, $dbpass);
      $stmt = $db->prepare("SELECT * from `Products` where id='$item_id' LIMIT 1");
      $stmt->execute();
      while(($data = $stmt->fetch()) !== false) {
                $product_name = htmlspecialchars($data['original_name']) ;  
                $price= htmlspecialchars($data['price']) ; 
                $img = htmlspecialchars($data['product_name']) ;
     
}
    $pricetotal = $price * $each_item['quantity'];
    $cartTotal = $pricetotal + $cartTotal;
    setlocale(LC_MONETARY, "en_US");
    $pricetotal = money_format("%10.2n", $pricetotal);
    $product_id_array .= "$item_id-".$each_item['quantity'].","; 
    $cartOutput .= "<tr>";
    $cartOutput .= '<td><a>' . $product_name . '</a><br /><img src="images/' . $img . '.jpeg" alt="' . $product_name. '" width="300" height="250" border="1" /></td>';
    $cartOutput .= '<td><label for="cars">Choose a Size:</label>
    <select id="size">
  <option value="7">7</option>
  <option value="7.5">7.5</option>
  <option value="8">8</option>
  <option value="8.5">8.5</option>
  <option value="9">9</option>
  <option value="9.5">9.5</option>
  <option value="10">10</option>
  <option value="10.5">10.5</option>
  <option value="11">11</option>
  <option value="11.5">11.5</option>
  </select></td>';
    $cartOutput .= '<td>$' . $price . '</td>';
    $cartOutput .= '<td><form action="yourorder.php" method="post">
    <input name="quantity" type="text" value="' . $each_item['quantity'] . '" size="1" maxlength="2" />
    <input name="adjustBtn' . $item_id . '" type="submit" value="change" />
    <input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
    </form></td>';
    $cartOutput .= '<td>' . $pricetotal . '</td>';
    $cartOutput .= '<td><form action="yourorder.php" method="post"><input name="deleteBtn' . $item_id . '" type="submit" value="Remove Item" /><input name="index_to_remove" type="hidden" value="' . $i . '" /></form></td>';
    $cartOutput .= '</tr>';
    $i++; 
    } 
  setlocale(LC_MONETARY, "en_US");
  $cartTotal = money_format("%10.2n", $cartTotal);
  $cartTotal = "<div style='font-size:18px; margin-top:12px;' align='right'>Cart Total : ".$cartTotal." USD</div>";
   
}
?>
<?php 
if (isset($_GET['done']) && $_GET['done'] == "confirm") {
 $h = 'document.getElementById("size")'
  echo "$h";
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

.button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
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
  <a class="active" href="yourorder.php">Your Order</a>
  <a href="history.php">Order History</a>
  
 
  
</div>

<div style="padding-left:16px">
<div align="center" id="mainWrapper">
  
  <div id="pageContent">
    <div style="margin:24px; text-align:left;">
  
    <br />
    <table width="100%" border="1" cellspacing="0" cellpadding="6">
      <tr>
        <td width="18%" bgcolor="#C5DFFA"><strong>Product</strong></td>
        <td width="10%" bgcolor="#C5DFFA"><strong>Size</strong></td>
        <td width="10%" bgcolor="#C5DFFA"><strong>Unit Price</strong></td>
        <td width="9%" bgcolor="#C5DFFA"><strong>Quantity</strong></td>
        <td width="9%" bgcolor="#C5DFFA"><strong>Total</strong></td>
        <td width="9%" bgcolor="#C5DFFA"><strong>Remove</strong></td>
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
    <?php echo $cartTotal; ?>
    <br />
    <br />
       <a href="yourorder.php?done=confirm" class="button">Order Confirm</a>
    <br />
    <br />
        <a href="yourorder.php?cmd=emptycart" class="button">Click Here to Empty Your Shopping Cart</a>
    </div>
   <br />
  </div> 
</div>
</div>
</body>
</html>


