<?php

namespace Layer\Entities;

use Illuminate\Database\Eloquent\Model;
use Core\Exception\RestException;
use Core\Manager\ManagerTrait;
use Core\Repository\RepositoryTrait;

/**
* 
*/
class Ip extends Model 
{

	use ManagerTrait, RepositoryTrait;

    protected $table = 'ip_s';

    public $timestamps = false;

    protected $primaryKey = 'id_ip';

    // nombre => nombre en base
    protected $dictionary = [
    	"id_ipp" => 'id_ip',
    	"ipp"	=> 'ip'
    ];

    protected $rules = [
    	"id_ipp" => [''],
    	"ipp"	=> ['required|regex:/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/']
    ];

    public function add($data)
    {
    	return $this -> insert($data);
    }

    public function search($where = [])
    {
        $results = $this->where($where)->get()->each(function($item){
            $item -> translateToUser();
        })->toArray();

        return $results;
    }
	
}