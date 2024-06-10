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
        $input = [
            'sender' => strtolower(trim($payload['sender'])),
            'receiver' => strtolower(trim($payload['receiver'])),
            'title' => $payload['title'],
            'message' => $payload['message'],
            'status' => MailSent::$STATUS_PROCESSING,
        ];
        return DB::transaction(function () use($input) {
            $mailSent = $this->mailSentRepository->create($input);
            if (!$mailSent) {
                throw new \Exception('Failed send mail', 422);
            }
            // Publish to queue
            $this->queue->publish(
                array_merge($input, ['id' => $mailSent->id]), 
                'email', 
                '', 
                'email'
            );
            return $mailSent;
        }); 
    }
}