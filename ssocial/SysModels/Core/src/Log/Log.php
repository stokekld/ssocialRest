<?php
/**
* Archivo que contiene la clase de Log.
*
* @author Humberto de Jesus Flores Acuña <joy_warmgun@hotmail.com>
* @version 0.0.2
* @package Core\log
*/

namespace Core\Log;

date_default_timezone_set('America/Mexico_City');

/**
* Definición del archivo log.
*/
define("FILE_LOG", __DIR__.'/../../logs/System.log');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\WebProcessor;


/**
* Clase para llevar el log del sistema.
*
* Esta clase crea un log e inserta información.
*/
class Log
{

	/**
	* @var string $file Contiene el archivo de log.
	*/
	private static $file = FILE_LOG;

	/**
	* Método que retorna el ambiente de la aplicación.
	*
	* @return string
	*/
	private static function getEnviroment()
	{
		return getenv('APP_ENV');
	}

	/**
	* Método que crea el log.
	* 
	* @param string $name Contiene el nombre del log.
	* @param string $filePath Contiene el archivo del log.
	* @param string $filePath Contiene el archivo del log.
	* @param string $level Contiene el nivel del log. Ejemplo: Logger::WARNING
	*
	* @return Logger Retorna objeto
	*/
	private static function createLog($name = "", $filePath = "", $level = "")
	{
		$log = new Logger($name);
		$log->pushHandler(new StreamHandler($filePath, $level));
		return $log;
	}

	/**
	* Método que ejecuta la creación del log (createLog) y agrega informacion web.
	*
	* @return Logger
	*/
	private static function logSystem()
	{
		$log = self::createLog('Sistema.'.self::getEnviroment(), self::$file);
		$log->pushProcessor(new WebProcessor());
		return $log;
	}

	/**
	* Método para saber si estamos en ambiente debug.
	*
	* @return boolean
	*/
	public static function isDebugging()
	{
		return (getenv('APP_DEBUG') === 'true') or (self::getEnviroment() === 'testing');
	}

	/**
	* Método para agregar un error en el log.
	*
	* @param string $name Agrega un nombre.
	* @param array $data Agrega información.
	*/
	public static function addError($name = "", $data = array() )
	{
		$log = self::logSystem();
		$log->addError($name, $data);
	}

	/**
	* Método para agregar un info en el log.
	*
	* @param string $name Agrega un nombre.
	* @param array $data Agrega información.
	*/
	public static function addInfo($name = "", $data = array() )
	{
		$log = self::logSystem();
		$log->addInfo($name, $data);
	}

	/**
	* Método para agregar un warning en el log.
	*
	* @param string $name Agrega un nombre.
	* @param array $data Agrega información.
	*/
	public static function addWarning($name = "", $data = array() )
	{
		$log = self::logSystem();
		$log->addWarning($name, $data);
	}

	/**
	* Método para agregar un debug en el log.
	*
	* @param string $name Agrega un nombre.
	* @param array $data Agrega información.
	*/
	public static function addDebug($name = "", $data = array() )
	{
		$log = self::logSystem();
		$log->addDebug($name, $data);
	}
	
	/**
	* Método para guardar una excepción en el log y lanzarla.
	* 
	* @param string $file Nombre del archivo donde se generó la excepción.
	* @param string $message Mensaje de la excepción.
	* @param int $code Código propio de la excepción.
	*/
	public static function addException($file, $message, $code)
	{
		self::addError("Exception", array("file" => $file, "message" => $message, "code" => $code));
	}

	/**
	* Método para guardar una excepción de mysql en el log y lanzarla.
	*
	* @param string $file Nombre del archivo donde se generó la excepción.
	* @param \Illuminate\Database\QueryException $exception Contiene la Excepción de Mysql.
	*/
	public static function addErrorMysql($file, $exception)
	{
		self::addError("Mysql", array("file" => $file, "message" => $exception -> getMessage(), "code" => $exception -> getCode()));
	}
}