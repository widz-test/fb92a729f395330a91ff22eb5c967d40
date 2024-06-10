<?php

namespace Core\Mail\Service\Action;

use Core\Mail\Entity\Repository\MailSentRepository;

abstract class BaseMailAction {
    /**
     * @var MailSentRepository
     */
    protected MailSentRepository $mailSentRepository;

    /**
     * Constructor
     *
     * @param MailSentRepository $mailSentRepository
     */
    public function __construct(MailSentRepository $mailSentRepository) {
        $this->mailSentRepository = $mailSentRepository;
    }
}