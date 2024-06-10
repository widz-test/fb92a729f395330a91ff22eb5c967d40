<?php

namespace Core\Mail\Entity\Model;

class MailSent extends BaseModel
{
    static $STATUS_FAILED = 'failed';
    static $STATUS_PROCESSING = 'processing';
    static $STATUS_SUCCESS = 'success';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'mail_sent';

    /**
     * Get sender
     *
     * @return string
     */
    public function getSender(): string {
        return $this->sender;
    }

    /**
     * Get receiver
     *
     * @return string
     */
    public function getReceiver(): string {
        return $this->receiver;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus(): string {
        return $this->status;
    }

    /**
     * Get sent at
     *
     * @return string
     */
    public function getSentAt() {
        return $this->sent_at;
    }

    /**
     * Get exception
     *
     * @return string
     */
    public function getException() {
        return $this->exception;
    }
       
}
