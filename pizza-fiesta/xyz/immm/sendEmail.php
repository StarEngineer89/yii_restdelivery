<?php
//$owner_email_id ='harish.k.532@gmail.com';
$name = trim($_POST['name']);
$email = $_POST['email'];
$message = $_POST['message'];
$subject = $_POST['subject'];
$site_owners_email =trim('bijjuvinay@gmail.com'); 
$error = '';
if ($name=="") {
	$error['name'] = "Please enter your name";	
}
if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
	$error['email'] = "Please enter a valid email address";	
}
if ($message== "") {
	$error['message'] = "Please leave a comment.";
}
if( $subject == "" ) {
	$error['subject'] = 'Enter Subject';
}
if (!$error) {
	$headers = "From: ".$name." <".$email.">\r\n"
		."Reply-To: ".$email."\r\n"
		."X-Mailer: PHP/" . phpversion();
		$mail = mail($site_owners_email, $subject, $message,$headers);
	
	echo "<div class='success'>" . $site_owners_email . ". We've received your email. We'll be in touch with you as soon as possible! </div>";

} # end if no error
else {
$response ="";
echo $response;
echo "<div class='success'>" . $name . ". Sending Fail </div>";
} # end if there was an error sending
?>