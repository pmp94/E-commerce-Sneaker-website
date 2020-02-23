<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(	   isset($_POST['name'])
	&& isset($_POST['PhoneNumber'])
	&& isset($_POST['email']) 
	&& isset($_POST['password'])
	&& isset($_POST['confirm'])
	){
	$pass = $_POST['password'];
	$conf = $_POST['confirm'];
	if($pass != $conf){
	
		
		$msg = "Passwords don't match, what's going on there?";
	}
	else{
		$msg = "You are registered to flipcart";
		
		$pass = password_hash($pass, PASSWORD_BCRYPT);
		echo "<br>$pass<br>";
		
		require("config.php");
		$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
		try {
			$db = new PDO($connection_string, $dbuser, $dbpass);
			$stmt = $db->prepare("INSERT INTO `Users3`
							(name, PhoneNumber, email, password) VALUES
							(:name, :PhoneNumber, :email, :password)");
			$email = $_POST['email'];
			$name = $_POST['name'];
            $PhoneNumber = $_POST['PhoneNumber'];
			$params = array(":name"=> $name,
						":PhoneNumber"=> $PhoneNumber,
						":email"=> $email, 
						":password"=> $pass);
			$stmt->execute($params);
			echo "<pre>" . var_export($stmt->errorInfo(), true) . "</pre>";
		}
		catch(Exception $e){
			echo $e->getMessage();
			exit();
		}
	}
	
}
?>

<html>
	<head>
		<title>My Project - Register</title>
		<style>
		body{
	     		background-color:red;
	                background-image: url(https://i.pinimg.com/474x/c6/5f/80/c65f806804e2e6c544350fc96b424e2e--learning-guitar-hd-backgrounds.jpg);
		        background-repeat: no-repeat;
			background-size: contain;
		
			color: white;
		}
		</style>
		<script>
			function doValidations(form){
				let isValid = true;
				if(!verifyName(form)){
					isValid = false; 
                }   
				if(!verifyPhoneNumber(form)){
					isValid = false; 
                }                
				if(!verifyEmail(form)){
					isValid = false;
				}
				if(!verifyPasswords(form)){
					isValid = false;
				}
				return isValid;
			}
			function verifyName(form){
				let ee = document.getElementById("name_error");
				if(form.name.value.length  == 0){
					ee.innerText = "Please enter the Name";
					return false;
				}
				else{
					ee.innerText = "";
				return true;
				}
			} 
			function verifyPhoneNumber(form){
				let ee = document.getElementById("PhoneNumber_error");
				if(form.PhoneNumber.value.length  == 0 || form.PhoneNumber.value.length  != 10){
					ee.innerText = "Please enter valid Phone Number";
					return false;
				}
				else{
					ee.innerText = "";
					return true;
				}
			}             
			function verifyEmail(form){
				let ee = document.getElementById("email_error");
				if(form.email.value.trim().length  == 0){
					ee.innerText = "Please enter an email address";
					return false;
				}
				else{
					ee.innerText = "";
					return true;
				}
			}
            
			function verifyPasswords(form){
				let pe = document.getElementById("password_error");
				if(form.password.value.length == 0 || form.confirm.value.length == 0){
					
					pe.innerText = "Please enter a password and a confirm password";
					return false;
				}
				if(form.password.value != form.confirm.value){
					
					pe.innerText = "Passwords don't match, please try again.";
					return false;
				}
				pe.innerText = "";
				return true;
			}
		</script>
	</head>
	<body onload="findFormsOnLoad();">
		<!-- This is how you comment -->
        <div align="center">
        <h1>Welcom to Flipcart</h1>
        <h2>Create an New Account</h2>
		<form name="regform" id="myForm" method="POST"
					onsubmit="return doValidations(this)">
            <div>
            	<label for="name">Name: </label><br>
                <input type="text" id="name" name="name" placeholder="Enter Name"/><br>
                <span id="name_error"></span>
            <div>
            	<label for="PhoneNumber">Phone Number:</label><br>
                <input type="number" id="PhoneNumber" name="PhoneNumber" placeholder="Enter Number"/><br>
                <span id="PhoneNumber_error"></span>
            </div>    
			<div>
				<label for="email">Email: </label><br>
				<input type="email" id="email" name="email" placeholder="Enter Email"/><br>
				<span id="email_error"></span>
			</div>
			<div>
				<label for="pass">Password: </label><br>
				<input type="password" id="pass" name="password" placeholder="Enter password"/>
			</div>
			<div>
			<label for="conf">Confirm Password: </label><br>
				<input type="password" id="conf" name="confirm"/ placeholder="Confirm password"><br>
				<span id="password_error"></span>
			</div>
			<div>
				<div>&nbsp;</div>
				<input type="submit" value="Register"/>
			</div>
		</form>
        </div>
		<?php if(isset($msg)):?>
			<span><?php echo $msg;?></span>
		<?php endif;?>
	</body>
</html>
