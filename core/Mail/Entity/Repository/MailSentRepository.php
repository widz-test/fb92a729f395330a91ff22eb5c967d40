<?php

namespace Core\Mail\Entity\Repository;

use Core\Mail\Entity\Model\MailSent;

class MailSentRepository extends BaseRepository {
    /**
     * Constructor
     *
     * @param MailSent $model
     */
    public function __construct(MailSent $model) {
        $this->model = $model;
    }
}