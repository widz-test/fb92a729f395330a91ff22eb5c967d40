<?php

namespace Core\Mail\Service\Action;

use Core\Mail\Entity\Model\MailSent;
use Illuminate\Database\Capsule\Manager as DB;

class MailSenderAction extends BaseMailAction {
    /**
     * Process
     *
     * @param array $payload
     * @return MailSent
     */
    public function process(array $payload): MailSent {
        return DB::transaction(function () use($payload) {
            $mailSent = $this->mailSentRepository->create([
                'sender' => strtolower(trim($payload['sender'])),
                'receiver' => strtolower(trim($payload['receiver'])),
                'title' => $payload['title'],
                'message' => $payload['message'],
                'status' => MailSent::$STATUS_PROCESSING,
            ]);
            if (!$mailSent) {
                throw new \Exception("Failed send mail", 422);
            }
            return $mailSent;
        }); 
    }

    /**
     * Validate
     *
     * @param array $payload
     * @return boolean
     */
    protected function validate(array $payload): bool {
        return true;
    }
}