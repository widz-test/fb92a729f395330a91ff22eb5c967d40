<?php

namespace Core\Mail\Service;

use Core\Mail\Entity\Model\MailSent;
use Core\Mail\Service\Action\MailWorkerAction;
use Core\Mail\Service\Action\MailSenderAction;

class MailService {
    protected MailSenderAction $mailSenderAction;
    protected MailWorkerAction $mailWorkerAction;
    
    /**
     * Constructor
     *
     * @param MailSenderAction $mailSenderAction
     * @param MailWorkerAction $mailWorkerAction
     */
    public function __construct(
        MailSenderAction $mailSenderAction,
        MailWorkerAction $mailWorkerAction
    ) {
        $this->mailSenderAction = $mailSenderAction;
        $this->mailWorkerAction = $mailWorkerAction;
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

    /**
     * Mail worker
     *
     * @param array $payload
     * @return void
     */
    public function mailWorker(array $payload): void {
        $this->mailWorkerAction->process($payload);
    }
}