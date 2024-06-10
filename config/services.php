<?php

use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Container\Container;
use App\Http\Controllers\MailController;
use Core\Foundation\Queue\RabbitMQ;
use Core\Foundation\Scheduler\Scheduler;
use Core\Mail\Entity\Model\MailSent;
use Core\Mail\Entity\Repository\MailSentRepository;
use Core\Mail\Service\Action\MailSenderAction;
use Core\Mail\Service\Action\MailWorkerAction;
use Core\Mail\Service\MailService;
use Illuminate\Validation\Factory;

return [
    'bindings' => function (Container $container) {
        $filesystem = new Filesystem();
        $loader = new FileLoader($filesystem, __DIR__.'/../resources/lang');
        $translator = new Translator($loader, 'en');
        $validationFactory = new ValidationFactory($translator);

        $container->singleton(ValidationFactory::class, function ($container) use ($validationFactory) {
            return $validationFactory;
        });
        $container->singleton(RabbitMQ::class, function ($container) {
            return new RabbitMQ();
        });
        $container->singleton(Scheduler::class, function ($container) {
            return new Scheduler();
        });
        $container->singleton(MailSent::class, function ($container) {
            return new MailSent();
        });
        $container->singleton(MailSentRepository::class, function ($container) {
            return new MailSentRepository($container->make(MailSent::class));
        });
        $container->singleton(MailSenderAction::class, function ($container) {
            return new MailSenderAction(
                $container->make(MailSentRepository::class),
                $container->make(RabbitMQ::class)
            );
        });
        $container->singleton(MailWorkerAction::class, function ($container) {
            return new MailWorkerAction(
                $container->make(MailSentRepository::class),
                $container->make(RabbitMQ::class)
            );
        });
        $container->singleton(MailService::class, function ($container) {
            return new MailService(
                $container->make(MailSenderAction::class),
                $container->make(MailWorkerAction::class),
            );
        });
        $container->singleton(Translator::class, function ($container) use($translator) {
            return $translator;
        });
        $container->singleton(
            App\Http\Controllers\MailController::class, function($container) {
                return new MailController(
                    $container->make(MailService::class), 
                    $container->make(Factory::class)
                );
            }
        );
    }
];