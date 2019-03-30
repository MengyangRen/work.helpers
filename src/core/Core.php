<?php
namespace Src\Core;

defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));
defined('STDERR') or define('STDERR', fopen('php://stderr', 'w'));

use Src\Conf\DbConfig;
use Symfony\Component\Console\Application;
use Illuminate\Database\Capsule\Manager as Database;

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *  核心类 
 * @author  v.r
 * @copyright copyright http://my.oschina.net/u/1246814
 * 
 */
class Core {

	public static $name = 'woker-helpers';
	public static $ver  = '1.0.0';

	/**
     * @var An Command service atlas
     * Defaults to true.
     */
	public static $enroll = [];

	/**
     *  enroll command 
     *
     * @return mixed logs default cli-text, 
     * else Exception
     * 
     */
	public static function enroll() {
		Core::$enroll = [
			'demo' => ['class' => 'Src\Cmd\DemoCommand'],
			'makeSchema'=> ['class' => 'Src\Cmd\MakeSchemaCommand'],
			'comparison'=> ['class' => 'Src\Cmd\ComparisonCommand'],
			'monitor'=> ['class' => 'Src\Cmd\MonitorCommand'],
			'multiProcess'=> ['class' => 'Src\Cmd\MultiProcessCommand'],
		];
	}

    public static function loadDbConfig() {
		$database = new Database();
		$database->addConnection(DbConfig::$dbs['default']);
		$database->setAsGlobal();
	}
    /**
     *  run 
     *
     * @return mixed logs default cli-text, 
     * else Exception
     * 
     */
	public static function run() {
		Core::loadDbConfig();
		Core::enroll();
		$application = new Application(Core::$name,Core::$ver);
		foreach (Core::$enroll as $item)
			$application->add(new $item['class']());
		$application->run();
	}
}

