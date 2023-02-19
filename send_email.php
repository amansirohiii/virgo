<?php
// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = $_POST["name"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	$message = $_POST["message"];

	$to = "amansirohi@duck.com"; // replace with your own email address
	$headers = "From: $email\r\n" .
	           "Reply-To: $email\r\n" .
	           "X-Mailer: PHP/" . phpversion();
	$body = "Name: $name\nEmail: $email\nMobile: $phone\n\n$message";

	// Send email using Gmail SMTP server
	require_once "PHPMailer/src/PHPMailer.php"; // path to PHPMailer autoload file
	$mail = new PHPMailer\PHPMailer\PHPMailer(true);
	$mail->isSMTP();
    $mail->Host = 'smtp.porkbun.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'virgo@amansirohi.biz'; // replace with your Gmail email address
    $mail->Password = 'w@3C8!AdXbGmWgN'; // replace with your Gmail password
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
?>
