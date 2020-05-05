<?php
session_start();
if (!isset($_SESSION['id'])) {
 header("location:admin_login.php"); 
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
      $stmt = $db->prepare("SELECT * from `admin`);
      $stmt->execute();
       while(($data = $stmt->fetch()) !== false) {
             $datas[] = $data;        
       }
$i=0;
foreach($datas as $data){ 
$cartOutput .= "<tr>";
$cartOutput .= '<td><a>' .$data['Product_name'] . '</a></td>';
$cartOutput .= '<td>' . $data['Quantity'] . '</td>';
$cartOutput .= '</tr>';
$i++ ;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div style="padding-left:16px">
<div align="center" id="mainWrapper">
  
  <div id="pageContent">
    <div style="margin:24px; text-align:left;">
  
    <br />
    <table width="100%" border="1" cellspacing="0" cellpadding="6">
      <tr>
        <td width="9%" bgcolor="#C5DFFA"><strong>Product Name</strong></td>
        <td width="9%" bgcolor="#C5DFFA"><strong>Quantity</strong></td>
      </tr>
     <?php echo $cartOutput; ?>

    </table>
    </div>
   <br />
  </div> 
</div>
</div>
</body>
</html>
