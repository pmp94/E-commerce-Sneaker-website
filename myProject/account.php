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
      $stmt = $db->prepare("SELECT * from `Users3` where id='" . $_SESSION['id'] . "'  LIMIT 1");
      $stmt->execute();
      while(($data = $stmt->fetch()) !== false) {
                $user_name = htmlspecialchars($data['Name']) ;  
                $user_email= htmlspecialchars($data['email']) ; 
                $user_phone_number = htmlspecialchars($data['PhoneNumber']) ;
     
}
?>
<?php
if(isset($_POST["updateprofile"])){
        $email = $_POST['email'];
        $username = $_POST['name'];
	$phone_number =  $_POST['number'];
	function count_digit($number) {
  	return strlen($number);
	}
	$number_of_digits = count_digit($phone_number); 
	if($number_of_digits != 10){
		echo '<script>alert("Invalid Phone Number ")</script>';
	}else{
	$db = new PDO($connection_string, $dbuser, $dbpass);
	//$stmt = $db->prepare("UPDATE `Users3` SET email= '$email', Name= '$username', PhoneNumber= '$phone_number',  where id='" . $_SESSION['id'] . "'");
        //$stmt->execute();
	$sql = "UPDATE Users3 SET Name = ? , email = ? , PhoneNumber = ? WHERE id = '" . $_SESSION['id'] . "'";
	$db->prepare($sql)->execute([ $username, $email, $phone_number]);

	
	echo '<script>alert("successfully Saved ")</script>';
	//header('Location: '.$_SERVER['REQUEST_URI']);
	}	
}
?>
<?php
if(isset($_POST["updatepassword"])){
        $pass = $_POST['current'];
        $newpass = $_POST['new'];
	$conpass =  $_POST['confnew'];
	$db = new PDO($connection_string, $dbuser, $dbpass);
	      $stmt = $db->prepare("SELECT * from `Users3` where id='" . $_SESSION['id'] . "'  LIMIT 1");
	      $stmt->execute();
	      while(($data = $stmt->fetch()) !== false) {
			$userpassword = htmlspecialchars($data['password']);
	      }
	if(password_verify('$pass', '$userpassword')){
		echo '<script>alert("Current Password does not match ")</script>';
	}else{
		if($conpass != $newpass){
			echo '<script>alert("New Password and confirm New password does not match")</script>';
		}else{
		$newpass = password_hash($newpass, PASSWORD_BCRYPT);
		$sql = "UPDATE Users3 SET password = ?  WHERE id = '" . $_SESSION['id'] . "'";
		$db->prepare($sql)->execute([$newpass]);
		echo '<script>alert("successfully Saved ")</script>';
		}
	}
}
?>	
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
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
  <a class="active" href="account.php">Account</a>
  <a href="search.php">Search</a>
  <a href="yourorder.php">Your Order</a>
  <a href="history.php">Order History</a>
</div>
<div class="row">
	<div class="col-sm-6" style="background-color:lavender;">
		<div class="container py-2">
		    <div class="row my-2">
		        <div class="col-lg-4">
		            <h2 class="text-center font-weight-light">User Profile Update</h2>
		        </div>
		        <div class="col-lg-8">
		        </div>
		        <div class="col-lg-8 order-lg-1 personal-info">
		            <form role="form" method="POST">
		                <div class="form-group row">
		                    <label class="col-lg-3 col-form-label form-control-label">User Name</label>
		                    <div class="col-lg-9">
		                        <input id="name" name="name" class="form-control" type="text" value="<?php echo "$user_name";?>" required />
		                    </div>
		                </div>
		                <div class="form-group row">
		                    <label class="col-lg-3 col-form-label form-control-label">Phone Number</label>
		                    <div class="col-lg-9">
		                        <input id="number" name="number" class="form-control" type="number" value="<?php echo "$user_phone_number";?>" required/>
		                    </div>
		                </div>
		                <div class="form-group row">
		                    <label class="col-lg-3 col-form-label form-control-label">Email</label>
		                    <div class="col-lg-9">
		                        <input id="email" name="email" class="form-control" type="email" value="<?php echo "$user_email";?>" required/>
		                    </div>
		                </div>

		                <div class="form-group row">
		                    <div class="col-lg-9 ml-auto text-right">
		                        <input name="updateprofile" type="submit" class="btn btn-primary" value="Save" />
		                    </div>
		                </div>
		            </form>
		        </div>
		        <div class="col-lg-4 order-lg-0 text-center">
		            <img src="//api.adorable.io/avatars/120/trickst3r.png" class="mx-auto img-fluid rounded-circle" alt="avatar" />
		        </div>
		    </div>
		</div>
	</div>
	 <div class="col-sm-6" style="background-color:lavenderblush;">
		 <div class="container py-2">
		    <div class="row my-2">
		        <div class="col-lg-4">
		            <h2 class="text-center font-weight-light">User Password Update</h2>
		        </div>
		        <div class="col-lg-8">
		        </div>
		        <div class="col-lg-8 order-lg-1 personal-info">
		            <form role="form" method="POST">
		                <div class="form-group row">
		                    <label class="col-lg-3 col-form-label form-control-label"> Current Password</label>
		                    <div class="col-lg-9">
		                        <input id="current" name="current"  class="form-control" type="password" value="" required/>
		                    </div>
		                </div>                

		                <div class="form-group row">
		                    <label class="col-lg-3 col-form-label form-control-label">New Password</label>
		                    <div class="col-lg-9">
		                        <input id="new" name="new" class="form-control" type="password" value="" required />
		                    </div>
		                </div>
		                <div class="form-group row">
		                    <label class="col-lg-3 col-form-label form-control-label">Confirm New password</label>
		                    <div class="col-lg-9">
		                        <input id="confnew" name="confnew"  class="form-control" type="password" value="" required/>
		                    </div>
		                </div>
		                <div class="form-group row">
		                    <div class="col-lg-9 ml-auto text-right">
		                        <input name="updatepassword" type="submit" class="btn btn-primary" value="Save" />
		                    </div>
		                </div>
		            </form>
		        </div>
		        <div class="col-lg-4 order-lg-0 text-center">
		            <img src="//api.adorable.io/avatars/120/trickst3r.png" class="mx-auto img-fluid rounded-circle" alt="avatar" />
		        </div>
		    </div>
		</div>
	</div>
</div>
	<div>
		<div class="text-center">
		<a href="logout.php" class="btn btn-info btn-lg">
		  <span class="glyphicon glyphicon-log-out"></span> Log out
		</a>
		</div>
	</div>
		
</body>
</html>

