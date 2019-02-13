<?php
function send_verification_code_to_email($email, $verification_code) {
    require '../PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;
    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'zakaria15-5729@diu.edu.bd';        // SMTP username
    $mail->Password = 'zakaria@classroom';                // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->setFrom('zakaria15-5729@diu.edu.bd', 'Supervisor Sulution');
    $mail->addAddress($email);     // Add a recipient
    
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    //$mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = "Supervisor solution's verification code";
    $mail->Body    = 'Welcome for joining to Supervisor solution. Your verification code: '.$verification_code;
    $mail->AltBody = 'Welcome for joining to Supervisor solution.';

    if(!$mail->send()) {
        //echo 'Message could not be sent.';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;

        return false;
    } else {
        //echo 'Message has been sent';
        return true;
    }
}

?>