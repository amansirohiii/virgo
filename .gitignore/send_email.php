<?php

/**
 * This uses the SMTP class alone to check that a connection can be made to an SMTP server,
 * authenticate, then disconnect
 */

//Import the PHPMailer SMTP class into the global namespace
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/PHPMailer.php";

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

//Create a new SMTP instance
$smtp = new SMTP();

//Enable connection-level debug output
$smtp->do_debug = SMTP::DEBUG_CONNECTION;

try {
    //Connect to an SMTP server
    if (!$smtp->connect('smtp.porkbun.com', 25)) {
        throw new Exception('Connect failed');
    }
    //Say hello
    if (!$smtp->hello(gethostname())) {
        throw new Exception('EHLO failed: ' . $smtp->getError()['error']);
    }
    //Get the list of ESMTP services the server offers
    $e = $smtp->getServerExtList();
    //If server can do TLS encryption, use it
    if (is_array($e) && array_key_exists('STARTTLS', $e)) {
        $tlsok = $smtp->startTLS();
        if (!$tlsok) {
            throw new Exception('Failed to start encryption: ' . $smtp->getError()['error']);
        }
        //Repeat EHLO after STARTTLS
        if (!$smtp->hello(gethostname())) {
            throw new Exception('EHLO (2) failed: ' . $smtp->getError()['error']);
        }
        //Get new capabilities list, which will usually now include AUTH if it didn't before
        $e = $smtp->getServerExtList();
    }
    //If server supports authentication, do it (even if no encryption)
    if (is_array($e) && array_key_exists('AUTH', $e)) {
        if ($smtp->authenticate('username', 'password')) {
            echo 'Connected ok!';
        } else {
            throw new Exception('Authentication failed: ' . $smtp->getError()['error']);
        }
    }
} catch (Exception $e) {
    echo 'SMTP error: ' . $e->getMessage(), "\n";
}
//Whatever happened, close the connection.
$smtp->quit();






<!-- <?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
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
?> -->
