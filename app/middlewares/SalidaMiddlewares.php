<?php


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class SalidaMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $mensaje = "despues";
        $respuestas = ['respuesta' => $mensaje];
        // $existingContent = (string) $response->getBody();


        $response->getBody()->write(json_encode($respuestas, true));

        return $response;
    }
}
