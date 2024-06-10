<?php

namespace Core\Mail\Service\Action;

use Core\Foundation\Mailer\Mailer;
use Core\Mail\Entity\Model\MailSent;

class MailWorkerAction extends BaseMailAction {
    /**
     * @var Mailer
     */
    protected Mailer $mailer;
    /**
     * @var MailSent|null
     */
    protected ?MailSent $mailSent = null;

    /**
     * Worker process
     *
     * @param array $payload
     * @return void
     */
    public function process(array $payload): void {
        // Worker
        $worker = function (string $msg): void {
            $payload = json_decode($msg, true);
            // Check sender and receiver
            if (!(isset($payload['id']) && isset($payload['sender']) && isset($payload['receiver']))) return;
            // Find mail data
            $this->mailSent = $this->mailSentRepository->findByID($payload['id']);
            if (!$this->mailSent) return; 
            // Init mailer
            $this->mailer = new Mailer();
            $status = MailSent::$STATUS_SUCCESS;
            $exception = "";
            try {
                $this->mailer->sendEmail(
                    $this->mailSent->getReceiver(),
                    $this->mailSent->getReceiver(),
                    $this->mailSent->getTitle(),
                    $this->mailSent->getMessage()
                );
            } catch(\Exception $e) {
                $status = MailSent::$STATUS_FAILED;
                $exception = $e->getMessage();
            }
            $this->mailSent->status = $status;
            $this->mailSent->exception = $exception;
            $this->mailSent->save();
        };
        // Consume
        $this->queue->consume('email', $worker);
    }
}