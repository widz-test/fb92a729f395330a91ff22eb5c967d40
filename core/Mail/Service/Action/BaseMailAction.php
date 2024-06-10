<?php

namespace Core\Mail\Service\Action;

use Core\Foundation\Queue\RabbitMQ;
use Core\Mail\Entity\Repository\MailSentRepository;

abstract class BaseMailAction {
    /**
     * @var MailSentRepository
     */
    protected MailSentRepository $mailSentRepository;
    /**
     * @var RabbitMQ
     */
    protected RabbitMQ $queue;

    /**
     * Constructor
     *
     * @param MailSentRepository $mailSentRepository
     * @param RabbitMQ $queue
     */
    public function __construct(
        MailSentRepository $mailSentRepository,
        RabbitMQ $queue
    ) {
        $this->mailSentRepository = $mailSentRepository;
        $this->queue = $queue;
    }
}