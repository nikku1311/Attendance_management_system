<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendAbsentEmail($toEmail, $studentName, $date) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'rnikitha1311@gmail.com';       // <-- Your Gmail here
        $mail->Password   = 'fkoy nzcjlwtwwato';          // <-- Your App Password here
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('rnikitha1311@gmail.com', 'Attendance System');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Your Child Was Absent';
        $mail->Body    = "Hello, your child <strong>$studentName</strong> was absent on <strong>$date</strong>.";

        $mail->send();
        echo "Email sent to $toEmail successfully!";
    } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>
