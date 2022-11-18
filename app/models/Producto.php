<?php

class Producto
{
    public $id;
    public $precio;
    public $nombre;
    public $medida;
    public $x_mayor;
    public $fechaBaja;

    public function crearUno()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (precio,nombre, medida,x_mayor) VALUES (:precio,:nombre, :medida, :x_mayor)");
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':x_mayor', $this->x_mayor, PDO::PARAM_STR);
        $consulta->bindValue(':medida', $this->medida);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, precio,nombre, medida ,x_mayor FROM productos ");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }
    public static function obtenerNacionalidad($x_mayor)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, precio,nombre, medida ,x_mayor,fechaBaja FROM productos WHERE x_mayor =:x_mayor");
        $consulta->bindValue(':x_mayor', $x_mayor, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }
    public static function obtenerTodosBaja()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, usuario, medida,fechaBaja FROM usuarios WHERE fechaBaja is not null ");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public static function obtenerUno($nombre)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id ,precio, nombre, medida ,x_mayor  FROM productos WHERE nombre = :nombre");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }
    public static function obtenerId($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,precio, nombre, medida ,x_mayor FROM productos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }
    public static function obtenerCriptoNacionalidad($x_mayor)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id,precio, nombre, medida ,x_mayor FROM productos WHERE x_mayor = :x_mayor");
        $consulta->bindValue(':x_mayor', $x_mayor, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }

    public function modificarProducto()
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia(); //precio, nombre, medida ,x_mayor 
        $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET nombre = :nombre, medida = :medida, precio = :precio, x_mayor = :x_mayor WHERE id = :id");
        $consulta->bindValue(':medida', $this->medida);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':medida', $this->medida);
        $consulta->bindValue(':id', $this->id);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':x_mayor', $this->x_mayor);
        $consulta->execute();
    }

    public static function borrarProducto($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
    }
}
