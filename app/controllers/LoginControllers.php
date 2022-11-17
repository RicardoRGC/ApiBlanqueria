<?php


class LoginControllers extends Usuario
{

    public function Verificar($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        if ($parametros != null) {
            $mail = $parametros['mail'];
            $clave = $parametros['clave'];


            $usuario = Usuario::obtenerUsuario($mail);

            if (password_verify($clave, $usuario->clave)) {
                $mensaje = 'Password is valid!';

                $datos = array('mail' => $parametros['mail'], 'tipo' => $usuario->tipo, 'id' => $usuario->id);
                //creo el token con los datos del usuario
                $token = AutentificadorJWT::CrearToken($datos);

                $payload = json_encode(array('OK' => $mensaje, 'jwt' => $token, 'tipo' => $usuario->tipo, 'id' => $usuario->id));

                $response->getBody()->write($payload);

                return $response
                    ->withHeader(
                        'Content-Type',
                        'application/json'
                    );
            } else {
                $mensaje = 'Invalid password.';
            }
        } else {
            $mensaje = "Error en Parametros";
        }

        $payload = json_encode($mensaje);

        $response->getBody()->write($payload);

        return $response
            ->withHeader(
                'Content-Type',
                'application/json'
            );
    }
}