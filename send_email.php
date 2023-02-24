<!-- 
<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = $_POST["name"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	$message = $_POST["message"];

	$to = "amansirohi@duck.com"; 
	$headers = "From: $email\r\n" .
	           "Reply-To: $email\r\n" .
	           "X-Mailer: PHP/" . phpversion();
	$body = "Name: $name\nEmail: $email\nMobile: $phone\n\n$message";

	// Send email using Gmail SMTP server
	require_once "PHPMailer/src/PHPMailer.php"; 
	$mail = new PHPMailer\PHPMailer\PHPMailer(true);
	$mail->isSMTP();
    $mail->Host = 'smtp.sendgrid.net';
    $mail->SMTPAuth = true;
    $mail->Username = 'apikey';
    $mail->Password = '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
	'; 
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
	
	$mail->setFrom($email, $name);
	$mail->addAddress($to);
	$mail->isHTML(false);
	$mail->Phone = $phone;
	$mail->Body = $body;
	if (!$mail->send()) {
	    echo "Error sending message: " . $mail->ErrorInfo;
	} else {
	    echo "Message sent successfully!";
	}
}
?>  -->
<?php

require_once('PHPMailer/src/PHPMailer.php'); // Include SendGrid library

$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['phone'];
$message = $_POST['message'];

$email_body = "This is a message from the Contact Us form:\n\nName: $name\nEmail: $email\nMobile: $phone\nMessage: $message";

$email = new \SendGrid\Mail\Mail(); // Create SendGrid object

$email->setFrom("$email", "$name"); // Set sender email and name
$email->setSubject("Contact Us Form Submission"); // Set email subject
$email->addTo("amansirohi@duck.com", "Recipient Name"); // Set recipient email and name

// Set email body
$email->addContent("text/plain", $email_body);

$sendgrid = new \SendGrid('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
'); // Set SendGrid API key

try {
    $response = $sendgrid->send($email); // Send email
    echo "Email sent successfully.";
} catch (Exception $e) {
    echo "Email not sent. Error message: ".$e->getMessage();
}

?>
