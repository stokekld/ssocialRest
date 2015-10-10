<?php

namespace Layer\User;

use Illuminate\Database\Eloquent\Model;
use Core\User\logInTrait;

class Admin extends Model 
{
    use logInTrait;

    protected $table = 'admin';
}
