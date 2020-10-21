<?php
declare(strict_types=1);

use App\Application\Middleware\ValidatorMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(ValidatorMiddleware::class);
};