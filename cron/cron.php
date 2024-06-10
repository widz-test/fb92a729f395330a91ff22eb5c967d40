<?php

require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../bootstrap/app.php';

use Core\Foundation\Queue\RabbitMQ;
use Core\Foundation\Scheduler\Scheduler;
use Core\Mail\Entity\Model\MailSent;
use Core\Mail\Entity\Repository\MailSentRepository;
use Core\Mail\Service\Action\MailWorkerAction;

$scheduler = new Scheduler();
$rabbitMQ = new RabbitMQ();
$mailSentRepository = new MailSentRepository(new MailSent());
$mailWorker = new MailWorkerAction($mailSentRepository, $rabbitMQ);

// Add tasks
$scheduler->add('*/1 * * * *', function() use($mailWorker) {
    try {
        $mailWorker->process([]);
    } catch(\Exception $e) {
        error_log($e->getMessage());
    }
});

// Start the scheduler
$scheduler->run();