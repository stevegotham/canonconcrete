<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name= trim($_POST["name"]);
	$email = trim($_POST["email"]);
	$message = trim($_POST["message"]);

	if ($name == "" OR $email == "" OR $message =="")	{
		$error_message =  "You must specify a value for name, email, and message.";
	}
	
	foreach( $_POST as $value ) {
		if(stripos($value,'Content-Type:') !== FALSE ) {
			$error_message =  "There was a problem with the information you entered.";
		}
	}
	
	if ($_POST["address"] != "") {
		$error_message =  "Your form submission has an error.";
	}
	
	require_once("../php/class.phpmailer.php");
	$mail = new PHPMailer();
	
	if(!$mail->ValidateAddress($email)) {
		$error_message =  "You must specify a valid email address.";
	}
	
	if (!isset($error_message)) {
		$email_body = "";
		$email_body = $email_body . "Name: " . $name . "<br>";
		$email_body = $email_body .  "Email: " . $email . "<br>";
		$email_body = $email_body .  "Message: <br>" . $message;
		$mail->SetFrom($email,$name);
		$address = "ehaines39@aol.com";
		$mail->AddAddress($address, "Canon Concrete Contractors");
		$mail->Subject = "Canon Concrete Inquiry / " . $name;
		$mail->MsgHTML($email_body);
		
		if($mail->Send()) {
			header("Location:thankyou.html");
			exit;
		}
		
	}  else {
		 	header("Location:error.html");
			exit;
		} 
}
?>  
