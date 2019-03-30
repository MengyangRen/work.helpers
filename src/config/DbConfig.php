<?php
namespace Src\Conf;
class DbConfig
{   

  /**
   * 数据库配置
   * @var array
   */
  public static $dbs = array(
     'default'=>array(
        'driver'    => 'mysql',
        'host'      => '127.0.0.1',
        'port'      => '3306',
        'database'  => 'Test_Data',
        'username'  => 'root',
        'password'  => 'sayhello2019',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
        'strict'    => false,
        'options'  => array(\PDO::MYSQL_ATTR_LOCAL_INFILE => true),
      ),
  ); 
}

//DbConfig::$dbs['default'];
