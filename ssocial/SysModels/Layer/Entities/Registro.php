<?php
/**
* Archivo que contiene la clase Registro
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Layer\Entities
*/

namespace Layer\Entities;

use Illuminate\Database\Eloquent\Model;
use Core\DataServices\DataServicesTrait;

/**
* Esta clase contiene el modelo de la tabla registro.
*/
class Registro extends Model 
{

	use DataServicesTrait;

    /**
    * @var string $table Contiene el nombre de la tabla en la base de datos.
    */
    protected $table = 'registro';

    /**
    * @var boolean $timestamps Deshabilita la integración de campos de creación del registro.
    */
    public $timestamps = false;

    /**
    * @var string $primaryKey Contiene el nombre de la llave primaria.
    */
    protected $primaryKey = 'id_registro';
    
    /**
    * @var array $dictionary Contiene el diccionario de los campos conocidos por el usuario a los campos de la tabla.
    * 
    * [ 'nombreCampoConocidoPorUsuario' => 'nombreRealTabla']
    */
    protected $dictionary = [
    	"idReg" => 'id_registro',
        "idServ" => 'id_serv',
        "regIni" => 'reg_inicio',
        "regFin" => 'reg_fin',
        "regAct" => 'reg_actividad',
        "regVal" => 'reg_validacion',
    ];

    /**
    * @var array $rules Contiene las reglas de validación de cada campo.
    *
    * [ 'nombreCampoConocidoPorUsuario' => ['reglas']]
    */
    protected $rules = [
    	// "id_ipp" => [''],
    	// "ipp"	=> ['required|regex:/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/']

        "idReg" => [''],
        "idServ" => ['required|numeric'],
        "regIni" => [''],
        "regFin" => [''],
        "regAct" => [''],
        "regVal" => ['required'],
    ];

    
	
}