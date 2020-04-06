<html>
	<head>
		<title>My Project - Login</title>
        		<style>
		body{
	     	background-color:red;
	        background-image: url(https://i.pinimg.com/474x/c6/5f/80/c65f806804e2e6c544350fc96b424e2e--learning-guitar-hd-backgrounds.jpg);
		    background-repeat: no-repeat;
			background-size: contain;
			color: white;
		}
		</style>
	</head>
	<body>
        <div align="center">
        <h1>Welcom to Flipcart</h1>
        <h2>Login</h2>
		<form name="loginform" id="myForm" method="POST">
			<label for="email">Email: </label>
			<input type="email" id="email" name="email" placeholder="Enter Email"/>
			<label for="pass">Password: </label>
			<input type="password" id="pass" name="password" placeholder="Enter password"/>
			<input type="submit" value="Login"/>
		</form>
	</body>
</html
<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if(isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])){
	$pass = $_POST['password'];
	$email = $_POST['email'];
	require("config.php");
	$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
	try {
		$db = new PDO($connection_string, $dbuser, $dbpass);
		$stmt = $db->prepare("SELECT id, email, password from `Users3` where email = :email LIMIT 1");
		
        $params = array(":email"=> $email);
        $stmt->execute($params);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
		if($result){
			$userpassword = $result['password'];
			if(password_verify($pass, $userpassword)){

				$_SESSION['user'] = $user;
				header("Location: test.php");
			}
			else{
				echo "Failed to login, invalid password";
			}
		}
		else{
			echo "Invalid email";
		}
	}
	catch(Exception $e){
		echo $e->getMessage();
		exit();
	}
}
?> 
