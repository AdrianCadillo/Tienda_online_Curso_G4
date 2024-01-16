<?php
namespace app\lib;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Throwable;

trait Email 
{
    private array $ConfigEmail;

    /** Método para envios de correos electrónicos */
    public function send(array $datos)
    {
        $this->ConfigEmail = require 'config/email.php';
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer();

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $this->ConfigEmail["HOST_MAIL"];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $this->ConfigEmail["USER_MAIL"];                     //SMTP username
            $mail->Password   = $this->ConfigEmail["PASSWORD_MAIL"];                               //SMTP password
            $mail->SMTPSecure = $this->ConfigEmail["SMTSECURE_MAIL"];            //Enable implicit TLS encryption
            $mail->Port       = $this->ConfigEmail["PUERTO_MAIL"]; 
            $mail->CharSet = "UTF-8";                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($this->ConfigEmail["EMISOR_CORREO_MAIL"],$this->ConfigEmail["EMISOR_NAME"]);
            $mail->addAddress($datos["email"],$datos["name"]);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $datos["asunto"];
            $mail->Body    = $datos["body"];

            return $mail->send();
        } catch (Throwable $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}