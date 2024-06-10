<?php

use App\Exceptions\Handler;
use App\Http\Controllers\MailController;
use Illuminate\Routing\Router;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

// Create a new container instance
$container = new Container();

// Create a new Dispatcher instance
$events = new Dispatcher($container);

// Create a new Router instance
$router = new Router($events, $container);

// Capture the request and bind it to the container
$request = Request::capture();
$container->instance(Request::class, $request);

// Load service bindings
$services = require __DIR__ . './../config/services.php';
$services['bindings']($container);

$container->singleton(Handler::class, function ($container) {
    return new Handler();
});

// Define routes
$router->get('/', function () {
    return 'Hello, world!';
});

$router->post('/mail/send', [MailController::class, 'sendMail']);

try {
    $response = $router->dispatch($request);
} catch (Exception $exception) {
    $handler = $container->make(Handler::class);
    $response = $handler->handle($exception, $request);
}

// Send the response
$response->send();