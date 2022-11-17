<?php
require_once './models/producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {

    $parametros = $request->getParsedBody();
    $archivo = $request->getUploadedFiles();

    if ($parametros != null && count($parametros) == 3) {
      try {
        // var_dump($parametros);
        $nombre = $parametros['nombre'];

        $usuario1 = Producto::obtenerUno($nombre);

        if (!$usuario1) {

          $precio = $parametros['precio'];
          $nombre = $parametros['nombre'];
          $nacionalidad = $parametros['nacionalidad'];

          try {
            // var_dump($archivo['foto']);
            $foto = $archivo['foto'];
            if (is_null($foto) || $foto->getClientMediaType() == "") {
              throw new Exception("No file");
            }
            $ext = $foto->getClientMediaType();
            // var_dump($ext);
            $ext = explode("/", $ext)[1];
            $ruta = "./Cryptos/" . $nombre . "." . $ext;
            $foto->moveTo($ruta); //mueve la imagen recibida a esa ruta
          } catch (Exception $e) {
            echo "no se pudo subir la imagen";
            $ruta = "";
          }
          // Creamos el usuario
          $usr = new Producto();
          $usr->precio = $precio;
          $usr->nombre = $nombre;
          $usr->foto = $ruta;
          $usr->nacionalidad = $nacionalidad;

          $id = $usr->crearUno();

          $payload = json_encode(array("mensaje" => "creado con exito id: $id "));
        } else {
          $payload = json_encode("ya existe");
        }
      } catch (Exception $e) {

        $payload = json_encode(array('error' => $e->getMessage()));
      }
    } else {
      $payload = json_encode('error no hay datos:precio,nombre,foto,nacionalidad');
    }


    $response->getBody()->write($payload);
    return $response
      ->withHeader(
        'Content-Type',
        'application/json'
      );
  }
  //-----------------------------------------------------------------------------------
  public function TraerUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $usr = $args['nacionalidad'];

    $usuario = Producto::obtenerCriptoNacionalidad($usr);
    $payload = json_encode($usuario);

    $response->getBody()->write($payload);
    return $response
      ->withHeader(
        'Content-Type',
        'application/json'
      );
  }
  //----------------------------------------------------------------------------------------------------------------------------------
  //-----------------------------------------------------------------------------------
  public function TraerNacionalidad($request, $response, $args)
  {
    // $parametros = $request->getParsedBody();
    $parametros = $request->getQueryParams();

    $usr = $parametros['nacionalidad'];
    var_dump($usr);
    $lista = Producto::obtenerNacionalidad($usr);
    $payload = json_encode(array("listaCripto" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader(
        'Content-Type',
        'application/json'
      );
  }
  //----------------------------------------------------------------------------------------------------------------------------------
  //-----------------------------------------------------------------------------------
  public function TraerId($request, $response, $args)
  {
    $body = $request->getParsedBody();

    $header = $request->getHeaderLine('Authorization');
    $token = trim(explode("Bearer", $header)[1]);
    $datos = AutentificadorJWT::ObtenerData($token);


    // var_dump($datos->mail);

    $parametros = $request->getQueryParams();

    $usr = $parametros['id'];

    $producto = Producto::obtenerId($usr);

    $payload = json_encode(array("listaCripto" => $producto, "datos" => $datos));
    // $payload = json_encode($producto);

    $response->getBody()->write($payload);
    return $response
      ->withHeader(
        'Content-Type',
        'application/json'
      );
  }
  //----------------------------------------------------------------------------------------------------------------------------------
  public function TraerTodos($request, $response, $args)
  {
    $lista = Producto::obtenerTodos();
    $payload = json_encode(array("listaCripto" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader(
        'Content-Type',
        'application/json'
      );
  }
  ///MODIFICAR----------------------------------------------------------------------------------
  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $archivo = $request->getUploadedFiles();
    $id = $parametros['id'];

    $producto = Producto::obtenerId(intval($id));

    // var_dump($producto);
    if (isset($producto->nombre)) {
      if (isset($parametros['nombre'])) {
        $producto->nombre = $parametros['nombre'];
      }
      if (isset($parametros['precio'])) {
        $producto->precio = $parametros['precio'];
      }
      if (isset($parametros['nacionalidad'])) {
        $producto->nacionalidad = $parametros['nacionalidad'];
      }
      if (isset($archivo['foto'])) {
        try {
          $foto = $archivo['foto'];
          if (is_null($foto)) {
            throw new Exception("No file");
          }

          $ext = $foto->getClientMediaType();
          $ext = explode("/", $ext)[1];
          $ruta = "./FotosArmas/" . $producto->nombre . "." . $ext;
          $foto->moveTo($ruta);

          if ($producto->foto != "") //si tiene una foto la muevo a backup
          {
            $rutaVieja = explode('/', $producto->foto);
            var_dump($rutaVieja);
            $nombreArchivo = array_pop($xp); //me traigo el nombre
            rename($producto->foto, './FotosArmas/Backup/' . $nombreArchivo);
          }


          $producto->foto = $ruta;
        } catch (Exception $e) {
          var_dump($e->getMessage());
        }
      }

      // var_dump($producto);
      $producto->modificarProducto();

      $payload = json_encode(array("mensaje" => "modificado con exito"));
      $response->getBody()->write($payload);
    } else {
      $response->withStatus(404, "No se encuentra ");
    }
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
  //-------------------------------------------------------------------------------------------------
  public function BorrarUno($request, $response, $args)
  {
    try {
      //code...
      $parametros = $request->getParsedBody();
      $id = $parametros['id'];

      Producto::borrarProducto($id);

      $payload = json_encode(array("mensaje" => " borrado con exito"));

      $response->getBody()->write($payload);
    } catch (Exception $e) {
      $payload = json_encode(array("mensaje" => "Error"));

      $response->getBody()->write($payload);
    }
    return $response
      ->withHeader(
        'Content-Type',
        'application/json'
      );
  }
}