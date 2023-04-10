<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."../");
$dotenv->load();

enviarEmail();

function enviarEmail(){

    if(isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['Comentario'])){
        //mandar correo
        $name = $_POST['nombre'];
        $email = $_POST['email'];
        $comment = $_POST['Comentario'];

        $mail = new PHPMailer();                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.office365.com';                   // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $_ENV['EMAIL'];                 // SMTP username
            $mail->Password = $_ENV['PASSWORD'];                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($_ENV['EMAIL'], 'Mailer');
            $mail->addAddress($_ENV['MAIL'], 'Mailer');     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Correo de contacto';
            $mail->Body    = 'Nombre: ' . $name . '<br/>Correo: ' . $email . '<br/>' . $comment;
            $mail->CharSet = 'UTF-8';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


            $mail->send();
            echo 'Message enviado';
            require_once 'index.php';
        } catch (Exception $e) {
            echo 'Error: ', $mail->ErrorInfo;
        }
       

    }else{
        return;
    }
}

?>
