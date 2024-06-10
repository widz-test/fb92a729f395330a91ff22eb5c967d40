<?php

namespace Core\Foundation\Mailer;

use Core\Foundation\Config\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    /**
     * @var PHPMailer
     */
    protected PHPMailer $mail;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->init();
    }

    /**
     * Init
     *
     * @return void
     */
    private function init()
    {
        $config = Config::get('mail.connections.smtp');
        try {
            $this->mail->SMTPDebug = 0; // Disable verbose debug output
            $this->mail->isSMTP(); // Set mailer to use SMTP
            $this->mail->Host = data_get($config, 'host');
            $this->mail->SMTPAuth = true; // Enable SMTP authentication
            $this->mail->Username = data_get($config, 'username');
            $this->mail->Password = data_get($config, 'password');
            $this->mail->SMTPSecure = data_get($config, 'encryption');
            $this->mail->Port = data_get($config, 'port');
            $this->mail->setFrom('mailservice@levart.com', 'Mailer');
            $this->mail->addReplyTo('info@levart.com', 'Information');
        } catch (Exception $e) {
            throw new Exception("Mailer configuration failed: " . $e->getMessage());
        }
    }

    /**
     * Send mail
     *
     * @param string $to
     * @param string $toName
     * @param string $subject
     * @param string $body
     * @return void
     */
    public function sendEmail(
        string $to, 
        string $toName, 
        string $subject, 
        string $body
    ) {
        try {
            // Recipients
            $this->mail->addAddress($to, $toName);

            // Content
            $this->mail->isHTML(true); // Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = $body;

            // Send the email
            $this->mail->send();
            error_log('Message has been sent');
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
        }
    }
}
?>
