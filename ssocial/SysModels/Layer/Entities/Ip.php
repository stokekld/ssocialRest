<?php

namespace Layer\Entities;

use Illuminate\Database\Eloquent\Model;
use Core\DataServices\DataServicesTrait;
/**
* 
*/
class Ip extends Model 
{

	use DataServicesTrait;

    protected $table = 'ip_s';

    public $timestamps = false;

    protected $primaryKey = 'id_ip';

    protected $guarded = ['id_ip'];

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