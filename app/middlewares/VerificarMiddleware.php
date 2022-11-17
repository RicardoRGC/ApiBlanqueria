<?php


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class VerificarMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            $esValido = false;
            $response = new Response();
            $header = $request->getHeaderLine('Authorization');
            if (empty($header))
                throw new Exception("No hay token");
            $token = trim(explode("Bearer", $header)[1]);
            AutentificadorJWT::verificarToken($token);
            $esValido = true;
            //------------------------------------------------

        } catch (Exception $e) {
            $payload = json_encode(array('error' => $e->getMessage()));
            $response->getBody()->write($payload);
        }

        if ($esValido) {

            $response = $handler->handle($request);
            // var_dump($response);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}