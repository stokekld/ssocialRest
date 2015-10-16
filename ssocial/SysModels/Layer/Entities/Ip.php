<?php
/**
* Archivo que contiene la clase Ip
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Layer\Entities
*/

namespace Layer\Entities;

use Illuminate\Database\Eloquent\Model;
use Core\DataServices\DataServicesTrait;

/**
* Esta clase contiene el modelo de la tabla ip_s.
*/
class Ip extends Model 
{

	use DataServicesTrait;

    /**
    * @var string $table Contiene el nombre de la tabla en la base de datos.
    */
    protected $table = 'ip_s';

    /**
    * @var boolean $timestamps Deshabilita la integración de campos de creación del registro.
    */
    public $timestamps = false;

    /**
    * @var string $primaryKey Contiene el nombre de la llave primaria.
    */
    protected $primaryKey = 'id_ip';
    
    /**
    * @var array $dictionary Contiene el diccionario de los campos conocidos por el usuario a los campos de la tabla.
    * 
    * [ 'nombreCampoConocidoPorUsuario' => 'nombreRealTabla']
    */
    protected $dictionary = [
    	"id_ipp" => 'id_ip',
    	"ipp"	=> 'ip'
    ];

    /**
    * @var array $rules Contiene las reglas de validación de cada campo.
    *
    * [ 'nombreCampoConocidoPorUsuario' => ['reglas']]
    */
    protected $rules = [
    	"id_ipp" => [''],
    	"ipp"	=> ['required|regex:/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/']
    ];
	
}