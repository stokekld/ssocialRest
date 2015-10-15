<?php

namespace Layer\User;

use Illuminate\Database\Eloquent\Model;
use Core\User\Helper\logInTrait;
use Core\DataServices\DataServicesTrait;
/**
* 
*/
class Servicio extends Model
{
	
	use logInTrait, DataServicesTrait;

	protected $table = 'serv_social';

	public $timestamps = false;

	protected $primaryKey = 'id_serv';

	// nombre => nombre en base
	protected $dictionary = [
		"id_ipp" => 'id_ip',
		"ipp"	=> 'ip'
	];

	protected $rules = [
		"id_ipp" => [''],
		"ipp"	=> ['required|regex:/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/']
	];
}