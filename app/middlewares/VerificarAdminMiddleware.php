<?php


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class VerificarAdminMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new Response();
        $esValido = false;
        try {
            $header = $request->getHeaderLine('Authorization');
            if ($header == "")
                throw new Exception("Not Token");

            $token = trim(explode("Bearer", $header)[1]);

            $payload = AutentificadorJWT::ObtenerData($token);
            $esValido = true;
        } catch (Exception $e) {
            $payload = json_encode(array('error No puede Ingresar' => $e->getMessage()));
            $response->getBody()->write($payload);

        }

        if ($esValido) {

            if ($payload->tipo == "admin") {

                // var_dump($request);

                $response = $handler->handle($request);

            } else {
                $payload = json_encode('Error usted no es admin');

                $response->getBody()->write($payload);
            }



        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}