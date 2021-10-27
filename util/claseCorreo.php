<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once './vendor/phpMailer/PHPMailer.php';
require_once './vendor/phpMailer/Exception.php';
require_once './vendor/phpMailer/SMTP.php';


class Correo 
{

    protected $correoMatriz = 'baursaecuador@gmail.com';
    protected $llaveMatriz = 'baursaEc99';
    protected $email;
    protected $nombre;
    protected $titulo;

    public function __construct($email,$nombre)
    {
        $this->nombre = $nombre;
        $this->email = $email;
    }

    public function enviarCorreo($titulo,$texto,$codigo) 
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        $enviar = false;

        try {
            //Server settings
           /*  $mail->SMTPDebug = SMTP::DEBUG_SERVER;  */                //Enable verbose debug output
            $mail->isSMTP();                                             //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                        //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                    //Enable SMTP authentication
            $mail->Username   = $this->correoMatriz;                     //SMTP username
            $mail->Password   = $this->llaveMatriz;                      //SMTP password
            $mail->SMTPSecure = 'tls';                                   //Enable implicit TLS encryption
            $mail->Port       = 587;                                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress($this->email, $this->nombre);              //Add a recipient
           
            $mail->addReplyTo('info@example.com', 'Information');
        
            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = $titulo;
            $mail->Body    = $texto.' '.$codigo;

            $mail->send();
            $enviar = true;
        } catch (Exception $e) {
            $enviar = false;
        }
        return $enviar;
    }
}
