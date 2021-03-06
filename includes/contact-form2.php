<?php 

	require_once("../includes/phpmailer/class.phpmailer.php");
	require_once("../includes/phpmailer/class.smtp.php");


$errors = array(); // array to hold validation erros
$data 	= array(); // array to pass back data

// validate the variables
  // if any of these variables dont' exist, add an error to our $error array

if (empty($_POST["name"])) {
	$errors["name"] = "Name is required";
}

if (empty($_POST["email"])){
	$errors["email"] = "Email is required";
}

if (empty($_POST["message"])){
	$errors["message"] = "Message is required";
}


// Return a response 
	// if there are any errors in our errors array, 

if (! empty($errors)){
	$data["success"] = false;
	$data["errors"] = $errors;
} else {
	// if there are no errors, process our form, then return a message
	$name = 		filter_var($_POST["name"], FILTER_SANITIZE_STRING);
	$email = 		filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
	$subject = 	filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
	$message = 	filter_var($_POST["message"], FILTER_SANITIZE_STRING);


	$to = "im@pbj.me";
	$subjectLine = "[Contact Form] " . $subject;
	// $headers = "From: " . $email . "\r\n";
	// $headers .= "Reply-To: ". $email . "\r\n";
	// $headers .= "MIME-Version: 1.0\r\n";
	// $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$body 	= "From: " . $name . "<br>";
	$body  .= "Email: " . $email . "<br>";
	$body  .= "Subject Line: " . $subject . "<br>";
	$body	 .= "Message: " . $message . "<br>";




	// php mailer shit

	$mail = new PHPMailer();
	$mail->IsSMTP();  // telling the class to use SMTP
	$mail->Host     = "smtp.patrickbjohnson.com"; // SMTP server
	$mail->SetFrom($email, $subject);
	$mail->AddReplyTo($email, $subject);
	$mail->AddAddress($to, "Test Tozz");
	$mail->Subect 	= $subject;
	$mail->Body 		= $body;
	$mail->WordWrap = 50;


	if($mail->Send()){
		$data["success"] = true;
		$data["message"] = "Success";
	} 
	else {
		$data["success"] = false;
		$data["errors"] = $errors;
	}
}

echo json_encode($data);

?>