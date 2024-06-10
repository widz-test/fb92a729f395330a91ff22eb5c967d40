<?php

use App\Exceptions\Handler;
use App\Http\Controllers\MailController;
use Core\Auth\Middleware\AuthMiddleware;
use Core\Auth\Service\AuthGoogleService;
use Illuminate\Routing\Router;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

// Create a new container instance
$container = new Container();

// Create a new Dispatcher instance
$events = new Dispatcher($container);

// Create a new Router instance
$router = new Router($events, $container);

// Create the GoogleOAuthService
$authGoogleService = new AuthGoogleService();
$authMiddleware = new AuthMiddleware($authGoogleService);

// Create the request
$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);
$psr7Request = $creator->fromGlobals();

// Convert PSR-7 request to Illuminate request
$httpFoundationFactory = new HttpFoundationFactory();
$illuminateRequest = Request::createFromBase($httpFoundationFactory->createRequest($psr7Request));

// Capture the request and bind it to the container
// $request = Request::capture();
// $container->instance(Request::class, $request);

// Load service bindings
$services = require __DIR__ . './../config/services.php';
$services['bindings']($container);

$container->singleton('oauth2middleware', function ($container) use($authMiddleware) {
    return $authMiddleware;
});

$container->singleton(Handler::class, function ($container) {
    return new Handler();
});

// Route to serve API documentation
$router->get('/', function () {
    $path = dirname(__FILE__, 2).'/public/docs/api-docs.json';
    if (file_exists($path)) {
        return new Response(file_get_contents($path), 200);
    } else {
        return new Response('File not found', 404);
    }
});

// Define a sample route
$router->post('/mail/send', [MailController::class, 'sendMail']);

try {
    // Dispatch the request
    $response = $authMiddleware->process($illuminateRequest, function($request) use ($router) {
        return $router->dispatch($request);
    });
} catch (Exception $exception) {
    $handler = $container->make(Handler::class);
    $response = $handler->handle($exception, $illuminateRequest);
}

// Send the response
$response->send();