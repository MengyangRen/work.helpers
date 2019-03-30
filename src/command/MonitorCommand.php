<?php
namespace Src\Cmd;

use Src\Util\SimpleTableHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *  Mysql-数据库监控 
 * @author  v.r
 * @copyright copyright http://my.oschina.net/u/1246814
 * 
 */

class MonitorCommand extends Command
{  

    /**
     * shells for path
     * 
     * @var shells 
     */
   public static  $shells =  [
       '5-SEC-MYSQL-STATUS'=>'d8e60f845f41bac7633273788133a5bb',
       '5-SEC-MYSQL-INNODBSTATUS'=>'10fa447e9049944848a643e8aeb413ef',
       '5-SEC-MYSQL-PROCESSLIST'=>'5c36ccaaf082ec6928c1fa5a1d9b1475',
       '5-SEC-MYSQL-MONITOR'=>'26fa7dde68e4fd71ae755b551e977103',
    ];

    public static $path = '/workspace-0nt1/tcp/msyql.dev/work.helpers/src/sh/mysql';

   /**
     *Registration Command Service
     *
     * @return mixed error default NULL
     * 
     */
    protected function configure()
    {

       $this->setName('Mysql:Monitor')
             ->setDescription('Database performance Monitoring')
             ->setHelp('Data monitoring command ')
             ->addArgument('cmdName', InputArgument::REQUIRED, '命令名称');
    }

    /**
     *Before the command runs, initialize the output operation
     *
     * @param $input
     * An input data object
     *
     * @param $output
     * An output data object
     * 
     * @return mixed logs default cli-text, 
     * else Exception
     * 
     */
    public function initialize(InputInterface $input, OutputInterface $output) {
      $laodShell = function() {
          self::$shells = array_map(function($shell) {
               return self::$path.'/'.$shell;
          },self::$shells);
      };
      $laodShell();
    }

   /**
     * Execute Command Service
     *
     * @param $input
     * An input data object
     *
     * @param $output
     * An output data object
     * 
     * @return mixed logs default cli-text, 
     * else Exception
     * 
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $makeCmd = function($cmd,$time){
           switch ($cmd) {
             case '5-SEC-MYSQL-STATUS':
                  return  self::$shells['5-SEC-MYSQL-STATUS'].' '.self::$path.'/5-sec-status-2019-03-29_01-status';
               # code...
               break;           
            case '5-SEC-MYSQL-INNODBSTATUS':
               # code...
               break;
            case '5-SEC-MYSQL-PROCESSLIST':
                return self::$shells['5-SEC-MYSQL-PROCESSLIST'].' '.self::$path.'/5-sec-status-2019-03-29_01-processlist';
               break;
            
            case '5-SEC-MYSQL-MONITOR':
                #开一个子进程处理就行了,保存pid, 关闭就直接删除pid
                return self::$shells['5-SEC-MYSQL-MONITOR'];
               break;
           }
        };

        $cmd = $makeCmd('5-SEC-MYSQL-STATUS',time());
        exec("{$cmd}", $out, $rc);     

        $out = array_map(function($cnt) {
           return array_filter(explode(' ',trim($cnt)));
        }, $out);

        SimpleTableHelper::MySqlStatusTable($output,$out);
    }
}