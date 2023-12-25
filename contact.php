<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $number = $_POST["number"];
    $message = $_POST["message"];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'reivax.caasi@gmail.com'; // Your Gmail email address
        $mail->Password   = 'hjao xxtt ieko vasq'; // Use the generated App Password stored in an environment variable
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, 'ssl' also accepted
        $mail->Port       = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('reivax.caasi@gmail.com'); // Replace with your email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "Name: $name<br>Email: $email<br>Number: $number<br>Message:<br>$message";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
    }
}
?>
