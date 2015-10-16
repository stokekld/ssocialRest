<?php
/**
* Archivo que contiene la clase admin
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.1
* @package Layer\User
*/

namespace Layer\User;

use Illuminate\Database\Eloquent\Model;
use Core\User\Helper\logInTrait;

/**
* Esta clase contiene el modelo de la tabla admin.
*/
class Admin extends Model 
{
    use logInTrait;

    /**
    * @var string $table Contiene el nombre de la tabla en la base de datos.
    */
    protected $table = 'admin';
}
