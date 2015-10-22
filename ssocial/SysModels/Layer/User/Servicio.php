<?php
/**
* Archivo que contiene la clase Servicio
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Layer\User
*/

namespace Layer\User;

use Illuminate\Database\Eloquent\Model;
use Core\User\Helper\logInTrait;
use Core\DataServices\DataServicesTrait;

/**
* Esta clase contiene el modelo de la tabla serv_social.
*/
class Servicio extends Model
{
	
	use logInTrait, DataServicesTrait;

	/**
    * @var string $table Contiene el nombre de la tabla en la base de datos.
    */
	protected $table = 'serv_social';

	/**
    * @var boolean $timestamps Deshabilita la integración de campos de creación del registro.
    */
	public $timestamps = false;

	/**
    * @var string $primaryKey Contiene el nombre de la llave primaria.
    */
	protected $primaryKey = 'id_serv';

	/**
    * @var array $dictionary Contiene el diccionario de los campos conocidos por el usuario a los campos de la tabla.
    * 
    * [ 'nombreCampoConocidoPorUsuario' => 'nombreRealTabla']
    */
	protected $dictionary = [
		"idServ" => 'id_serv',
		"nomServ" => 'serv_nombre',
		"apatServ" => 'serv_apaterno',
		"amatServ" => 'serv_amaterno',
		"semestreServ" => 'serv_semestre',
		"carreraServ" => 'serv_carrera',
		"userServ" => 'serv_user',
		"passServ" => 'serv_pass',
		"activoServ" => 'serv_activo',
	];

	/**
    * @var array $rules Contiene las reglas de validación de cada campo.
    *
    * [ 'nombreCampoConocidoPorUsuario' => ['reglas']]
    */
	protected $rules = [
		"idServ" => [''],
		"nomServ" => ['required|max:30'],
		"apatServ" => ['required|max:25'],
		"amatServ" => ['required|max:25'],
		"semestreServ" => ['numeric'],
		"carreraServ" => ['max:30'],
		"userServ" => ['required|max:15'],
		"passServ" => ['required|max:32'],
		"activoServ" => ['required'],
	];

	
	
	
	public function registros()
	{
		$registros = $this -> hasMany('Layer\Entities\Registro', 'id_serv', 'id_serv')->getResults();

		return $registros -> each( function($item){
			$item -> translateToUser();
		})->toArray();
	}
	
	
	
	
	
}