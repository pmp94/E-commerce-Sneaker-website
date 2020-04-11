
<?php
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
?>


<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 1 (if user attempts to add something to the cart from the product page)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
  $wasFound = false;
  $i = 0;
  // If the cart session variable is not set or cart array is empty
  if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
      // RUN IF THE CART IS EMPTY OR NOT SET
    $_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));
  } else {
    // RUN IF THE CART HAS AT LEAST ONE ITEM IN IT
    foreach ($_SESSION["cart_array"] as $each_item) { 
          $i++;
          while (list($key, $value) = each($each_item)) {
          if ($key == "item_id" && $value == $pid) {
            // That item is in cart already so let's adjust its quantity using array_splice()
            array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
            $wasFound = true;
          } // close if condition
          } // close while loop
         } // close foreach loop
       if ($wasFound == false) {
         array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
       }
  }
 
}
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 2 (if user chooses to empty their shopping cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
    unset($_SESSION["cart_array"]);
}
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 3 (if user chooses to adjust item quantity)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
    // execute some code
  $item_to_adjust = $_POST['item_to_adjust'];
  $quantity = $_POST['quantity'];
  $quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
  if ($quantity >= 100) { $quantity = 99; }
  if ($quantity < 1) { $quantity = 1; }
  if ($quantity == "") { $quantity = 1; }
  $i = 0;
  foreach ($_SESSION["cart_array"] as $each_item) { 
          $i++;
          while (list($key, $value) = each($each_item)) {
          if ($key == "item_id" && $value == $item_to_adjust) {
            // That item is in cart already so let's adjust its quantity using array_splice()
            array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
          } // close if condition
          } // close while loop
  } // close foreach loop
}
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 4 (if user wants to remove an item from cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
    // Access the array and run code to remove that array index
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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 5  (render the cart for the user to view on the page)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$cartOutput = "";
$cartTotal = "";
$pp_checkout_btn = '';
$product_id_array = '';
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
    $cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
} else {
  // Start PayPal Checkout Button
  $pp_checkout_btn .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="you@youremail.com">';
  // Start the For Each loop
  $i = 0; 
    foreach ($_SESSION["cart_array"] as $each_item) { 
    $item_id = $each_item['item_id'];
      $db = new PDO($connection_string, $dbuser, $dbpass);
$stmt = $db->prepare("SELECT * from `Products` where id='$item_id' LIMIT 1");
      $stmt->execute();

      while(($data = $stmt->fetch()) !== false) {
                $product_name = htmlspecialchars($data['original_name']) ;  
                $price= htmlspecialchars($data['price']) ; 
    
    
}
    $pricetotal = $price * $each_item['quantity'];
    $cartTotal = $pricetotal + $cartTotal;
    setlocale(LC_MONETARY, "en_US");
        $pricetotal = money_format("%10.2n", $pricetotal);
    // Dynamic Checkout Btn Assembly
    $x = $i + 1;
    $pp_checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $product_name . '">
        <input type="hidden" name="amount_' . $x . '" value="' . $price . '">
        <input type="hidden" name="quantity_' . $x . '" value="' . $each_item['quantity'] . '">  ';
    // Create the product array variable
    $product_id_array .= "$item_id-".$each_item['quantity'].","; 
    // Dynamic table row assembly
    $cartOutput .= "<tr>";
    $cartOutput .= '<td><a href="product.php?id=' . $item_id . '">' . $product_name . '</a><br /><img src="inventory_images/' . $item_id . '.jpg" alt="' . $product_name. '" width="40" height="52" border="1" /></td>';
    $cartOutput .= '<td>$' . $price . '</td>';
    $cartOutput .= '<td><form action="yourorder.php" method="post">
    <input name="quantity" type="text" value="' . $each_item['quantity'] . '" size="1" maxlength="2" />
    <input name="adjustBtn' . $item_id . '" type="submit" value="change" />
    <input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
    </form></td>';
    //$cartOutput .= '<td>' . $each_item['quantity'] . '</td>';
    $cartOutput .= '<td>' . $pricetotal . '</td>';
    $cartOutput .= '<td><form action="yourorder.php" method="post"><input name="deleteBtn' . $item_id . '" type="submit" value="X" /><input name="index_to_remove" type="hidden" value="' . $i . '" /></form></td>';
    $cartOutput .= '</tr>';
    $i++; 
    } 
  setlocale(LC_MONETARY, "en_US");
    $cartTotal = money_format("%10.2n", $cartTotal);
  $cartTotal = "<div style='font-size:18px; margin-top:12px;' align='right'>Cart Total : ".$cartTotal." USD</div>";
    // Finish the Paypal Checkout Btn
  $pp_checkout_btn .= '<input type="hidden" name="custom" value="' . $product_id_array . '">
  <input type="hidden" name="notify_url" value="https://www.yoursite.com/storescripts/my_ipn.php">
  <input type="hidden" name="return" value="https://www.yoursite.com/checkout_complete.php">
  <input type="hidden" name="rm" value="2">
  <input type="hidden" name="cbt" value="Return to The Store">
  <input type="hidden" name="cancel_return" value="https://www.yoursite.com/paypal_cancel.php">
  <input type="hidden" name="lc" value="US">
  <input type="hidden" name="currency_code" value="USD">
  <input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - its fast, free and secure!">
  </form>';
}



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
  <a href="account.php">Account</a>
  <a href="search.php">Search</a>
  <a class="active" href="yourorder.php">Your Order</a>
  
</div>

<div style="padding-left:16px">
  <body>
<div align="center" id="mainWrapper">
  
  <div id="pageContent">
    <div style="margin:24px; text-align:left;">
  
    <br />
    <table width="100%" border="1" cellspacing="0" cellpadding="6">
      <tr>
        <td width="18%" bgcolor="#C5DFFA"><strong>Product</strong></td>
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
<?php //echo $pp_checkout_btn; ?>
    <br />
    <br />
    <a href="yourorder.php?cmd=emptycart">Click Here to Empty Your Shopping Cart</a>
    </div>
   <br />
  </div>
  
</div>
</body>
</div>


</body>
</html>


