<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    protected function getConfig(string $subject) {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV["EMAIL_PORT"];
        $mail->Username = $_ENV["EMAIL_USER"];
        $mail->Password = $_ENV["EMAIL_PASS"];
        $mail->CharSet = 'UTF-8';

        $mail->setFrom("cuentas@appsalon.com");
        $mail->addAddress("cuentas@appsalon.com", "Appsalon.com");
        $mail->Subject = $subject;

        return $mail;
    }

    public function enviarConfirmacion() {
        $mail = $this->getConfig("Confirma tu cuenta");

        $contenido = "<html>";
        $contenido .= "<p><strong> Hola " . $this->nombre . "</strong></p>";
        $contenido .= "<p>Para confirmar tu cuenta entra en el sig. enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV["APP_URL"] . "/cuenta/confirmar?token={$this->token}'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esto, puedes ignorar este email</p>";
        $contenido .= "</html>";
        
        $mail->isHTML();
        $mail->Body = $contenido;
        $mail->send();
    }
    
    public function enviarRecuperacion() {
        $mail = $this->getConfig("Recupera tu contraseña");
        
        $contenido = "<html>";
        $contenido .= "<p><strong> Hola " . $this->nombre . "</strong></p>";
        $contenido .= "<p>Para restablecer tu contraseña entra en el sig. enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV["APP_URL"] . "/cuenta/password/reset?token={$this->token}'>Recuperar contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste esto, puedes ignorar este email</p>";
        $contenido .= "</html>";

        $mail->isHTML();
        $mail->Body = $contenido;
        $mail->send();
    }
}