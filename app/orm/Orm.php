<?php 
namespace app\orm;

interface orm{
  
    /** Método para inicializar la query => select *from tabla */
    public function initQuery();

    /** Método que ejecuta las consultas */
    public function get();

    /** Método para mostrar atributos de una tabla es específico */

    public function select();

    /** MÉTODO WHERE PARA MOSRAR REGISTROS DE ACUERDO A UNA CONDICION */
    public function Where(string $atributo,string $operador,string|int|null|bool|float $value);

    /** Método para realizar en or */
    public function WhereOr(string $atributo,string $operador,string|int|null|bool|float $value);


    /**
     * Vamos a definir los métodos para la orm
     * insertar, actualizar,eliminar
     */

     /*** insert */
     public function Insert(array $datos);

     /*** save para realizar registros */
     public function save();
     /*** actualizar o modificar */
     public function Update(array $datos);

     /** Para eliminar registros */
     public function delete(int $id);
}