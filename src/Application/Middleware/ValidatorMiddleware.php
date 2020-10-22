<?php

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Exceptions\ValidationException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

/**
 * Class ValidatorMiddleware
 *
 * @package App\Application\Middleware
 */
class ValidatorMiddleware implements MiddlewareInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    public function __invoke(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Exception
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (NestedValidationException $exception) {
            $messages = [];
            /** @var ValidationException $message */
            foreach($exception->getIterator() as $message) {
                $key = $message->getParam('name');
                if($key === null) {
                    continue;
                }
                $messages[$key] = $message->getMessage();
            }

            $response = new Response();
            $result = [
                'error' => [
                    'mensagem' => $exception->getMessage(),
                    'detalhes' => $messages,
                ],
            ];
            $response->getBody()->write(json_encode($result));
            $response->withHeader('Content-Type', 'application/json');

            return $response->withStatus(422);
        }
    }
}