<?php


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;


class BorrarMiddleware
{

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $parametros = $request->getParsedBody();
        $id = $parametros['id'];
        $method = $request->getMethod();
        // $uri = $request->getUri();
        // $headers = $request->getHeaders();
        // $body = $request->getBody();

        $response = $handler->handle($request);
        try {
            $header = $request->getHeaderLine('Authorization');
            if ($header == "")
                throw new Exception("Not Token");
            $token = trim(explode("Bearer", $header)[1]);

            $payload = AutentificadorJWT::ObtenerData($token);

        } catch (Exception $e) {
            $payload = json_encode(array('error No puede Ingresar' => $e->getMessage()));
            $response->getBody()->write($payload);

        }
        if ($method == 'DELETE') {
            // (id_usuario, id_cripto, accion, fecha_accion
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO logs (id_usuario, id_arma, accion, fecha_accion) VALUES (:id_usuario, :id_arma, :accion, :fecha_accion)");
            $consulta->bindValue(':id_usuario', $payload->id);
            $consulta->bindValue(':id_arma', $id);
            $consulta->bindValue(':accion', 'borrar');
            $fecha = new DateTime(date("d-m-Y"));
            $consulta->bindValue(':fecha_accion', date_format($fecha, 'Y-m-d H:i:s'));
            $consulta->execute();

            $mensaje = "Guardado Correctamente";

            $respuestas = ['respuesta' => $mensaje];
        }

        $response->getBody()->write(json_encode($respuestas, true));

        return $response;
    }
}