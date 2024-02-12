<?php
// application/libraries/Phpmailer_lib.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require APPPATH . 'libraries/PHPMailer/src/Exception.php';
require APPPATH . 'libraries/PHPMailer/src/PHPMailer.php';
require APPPATH . 'libraries/PHPMailer/src/SMTP.php';

class Phpmailer_lib
{
    public function __construct()
    {
        log_message('debug', 'PHPMailer class is loaded.');
    }

    public function enviar_correo($para, $asunto, $mensaje)
    {
        $CI = &get_instance();
        $CI->load->config('phpmailer_config');

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 1;
            $mail->isSMTP();
            $mail->Host       = $CI->config->item('smtp_host');
            $mail->SMTPAuth   = true;
            $mail->Username   = $CI->config->item('smtp_user');
            $mail->Password   = $CI->config->item('smtp_pass');
            $mail->SMTPSecure = $CI->config->item('smtp_crypto');
            $mail->Port       = $CI->config->item('smtp_port');

            $mail->setFrom($CI->config->item('smtp_user'), 'Tu Nombre');
            $mail->addAddress($para);

            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;

            $mail->send();
            return true;
        } catch (Exception $e) {
            log_message('error', 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
