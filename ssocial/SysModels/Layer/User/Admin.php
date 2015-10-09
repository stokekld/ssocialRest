<?php

namespace Layer\User;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model 
{
    protected $table = 'admin';

    public static function logIn($credentials)
    {
    	$obj = new static();



    	$results = $obj->select(["id_admin", "admin_pass", "admin_user"])->where(['admin_user' => $credentials['user'], 'admin_pass' => $credentials['password'] ])->get();

    	if ($results->count() != 1)
    		return false;

    	$data = [
			"data" => $results->first()->toArray(),
			"table" => $obj->getTable(),
			"type" => "admin",
    	];

    	return $data;
    }

    // protected $fillable = ['name', 'email', 'password'];

    // protected $hidden = ['password', 'remember_token'];
}
