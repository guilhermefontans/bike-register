<?php
declare(strict_types=1);

use App\Application\Actions\Bike\CreateBikeAction;
use App\Application\Actions\Bike\ListBikesAction;
use App\Application\Actions\Bike\ViewBikeAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });




    $app->post('/bikes', CreateBikeAction::class);

    $app->group('/bikes', function (Group $group) {
        $group->get('', ListBikesAction::class);
        $group->get('/{id}', ViewBikeAction::class);
        //$group->post('/', CreateBikeAction::class);
    });
};
