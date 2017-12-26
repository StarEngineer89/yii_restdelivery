<?php
$res_email_id = $_POST['res_email_id'];
$res_name = trim($_POST['res_name']);
$res_email = $_POST['res_email'];
$res_message = $_POST['res_message'];
$res_phone = trim($_POST['res_phone']);
$res_persons = $_POST['res_persons'];
$res_date = $_POST['res_date'];
$res_time = $_POST['res_time'];
$res_subject = $_POST['res_subject'];
$site_owners_email =trim($res_email_id); 
$error = '';
if ($res_name=="") {
	$error['res_name'] = "Please enter your name";	
}
if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $res_email)) {
	$error['res_email'] = "Please enter a valid email address";	
}
if ($res_message== "") {
	$error['message'] = "Please leave a comment.";
}
if( $res_phone == "" ){
	$error['res_phone'] = "Enter Valid Phone Number";
}
if( $res_persons == "" ) {
	$error['res_persons'] = 'Enter Number Persons';
}
if( $res_date == "" ) {
	$error['res_date'] = 'Enter reservation date';
}
if( $res_time == "" ) {
	$error['res_time'] = 'Enter reservation Time';
}
if( $res_subject == "" ) {
	$error['res_subject'] = 'Enter Subject';
}
if (!$error) {
	$message =  "Reservation Details : \r\n";
	$message .=  "------------------------- \r\n";
	$message .= "Name : " .$res_name. "\r\n";
	$message .= "Email Id : " .$res_email. "\r\n";
	$message .= "Phone : " .$res_phone. "\r\n";
	$message .= "Reservation On : "	.$res_date. " " .$res_time. "\r\n";
	$message .= "Number Of Persons : " .$res_persons. "\r\n";
	$headers = "From: ".$res_name." <".$res_email.">\r\n"
		."Reply-To: ".$res_email."\r\n"
		."X-Mailer: PHP/" . phpversion();
		$mail = mail($site_owners_email, $res_subject, $message,$headers);
	echo "<div class='success'>" . $res_name."We've received your Reservation Details. We'll be in touch with you as soon as possible!"; echo "</div>";

} # end if no error
else {
$response ="";
echo $response;
} # end if there was an error sending
?>