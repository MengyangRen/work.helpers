<?php
namespace Src\Util;

use Symfony\Component\Console\Helper\Table;

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *  表格简单生成器
 * 
 * @author  v.r
 * @copyright copyright http://my.oschina.net/u/1246814
 * 
 */

class SimpleTableHelper {

    /**
     * Get information about the enterprise the user is in
     * 
     * @param $output
     *  文件输出屏幕流
     * 
     * @param $data
     *  数据
     * 
     * @return cli,
     *  else Exception
     *  
     * @ingroup oauth2_section_4
     */
    public static function MySqlStatusTable($output,$data) {
        $table = new Table($output);
        $title =  array_shift($data);
        $table
            ->setHeaders($title)
            ->setRows($data);
        $table->render();
    }


    /**
     * Get information about the enterprise the user is in
     * 
     * @param $output
     *  文件输出屏幕流
     * 
     * @param $config
     *  配置文件数组信息
     * 
     * @return cli,
     *  else Exception
     *  
     * @ingroup oauth2_section_4
     */
    public static function SvrConfigTable($output,$config) {
        if (empty($config['server1']))  return false;
        $table = new Table($output);
        $table
            ->setHeaders(['Mysql Database Config'])
            ->setRows([$config['server1'],$config['server2']]);
        $table->render();
    }

    /**
     * Get information about the enterprise the user is in
     * 
     * @param $output
     *  文件输出屏幕流
     * 
     * @param $config
     *  配置文件数组信息
     * 
     * @return cli,
     *  else Exception
     *  
     * @ingroup oauth2_section_4
     */
    public static function IgnoreSchemaTable($output,$config) {
        if (empty($config['tablesToIgnore']))  return false;
        
        $table = new Table($output);
        $table
            ->setHeaders(['tablesToIgnore'])
            ->setRows([$config['tablesToIgnore']]);
        $table->render();
    }

    /**
     * Get information about the enterprise the user is in
     * 
     * @param $output
     *  文件输出屏幕流
     * 
     * @param $config
     *  配置文件数组信息
     * 
     * @return cli,
     *  else Exception
     *  
     * @ingroup oauth2_section_4
     */
    public static function IgnoreFieldsTable($output,$config) {
        if (empty($config['fieldsToIgnore']))  return false;

        $fieldsToIgnore = $config['fieldsToIgnore'];
        $fieldstable = array();
        foreach ($fieldsToIgnore as $table => $fields) {
            array_unshift($fields,$table); 
            $fieldstable[] = $fields;
        }
        $table = new Table($output);
        $table
            ->setHeaders(['fieldsToIgnore'])
            ->setRows($fieldstable);
        $table->render();
    }
    
    public static function ComparisonCommandHelp() {
     return <<<Help
    <info>配置文件说明</info>
        --server1   : 指定源数据库连接详细信息。如果只有一个服务器，则可以省略--server1标志
        --server2   : u指定目标数据库连接详细信息（如果它与server1不同）
        --template  : templates/simple-db-migrate.tmpl  - 指定输出模板（如果有）。默认情况下将是纯SQL
        --type      : schema或data或all  - 指定要在架构，数据或两者上执行的diff类型。schema是默认值
        --include   : up  或down或all  - 指定是否在输出中包含up，down或两个数据。up是默认值
        --nocomments: true  - 默认情况下，以哈希（＃）字符开头的自动注释包含在输出文件中，可以使用此参数删除
        --output    :/output-dir/today-up-schema.sql  -则默认文件名将成为当前目录中的migration.sql
        #tablesToIgnore :  -则为忽略比较的数据表
        # - table1
        # - table2
        # - table3
        #fieldsToIgnore: -则为忽略比较的数据表中的某些字段
        #  table1:
        #    - field1
        #    - field2
        #    - field3
        #  table4:
        #    - field1
   <info>example:</info>
         1.Srv2.Database:Srv2.Database
         2.Srv1.Database.table:Srv2.Database.table
        ./console  Mysql:Comparison server1.IMS_DEV:server2.IMS
        倒数第二个参数是要比较的内容。此工具可以比较数据库中的一个表或所有表（整个数据库）
Help;
    }
}