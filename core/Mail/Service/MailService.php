<?php

namespace Core\Mail\Service;

use Core\Mail\Entity\Model\MailSent;
use Core\Mail\Service\Action\MailSenderAction;

class MailService {
    protected MailSenderAction $mailSenderAction;
    
    /**
     * Constructor
     *
     * @param MailSenderAction $mailSenderAction
     */
    public function __construct(MailSenderAction $mailSenderAction) {
        $this->mailSenderAction = $mailSenderAction;
    }

    /**
     * Send mail
     *
     * @param array $payload
     * @return MailSent
     */
    public function sendMail(array $payload): MailSent {
        return $this->mailSenderAction->process($payload);
    }
}