<?php
namespace Src\Util;

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *  命令帮助Doc
 * 
 * @author  v.r
 * @copyright copyright http://my.oschina.net/u/1246814
 * 
 */

class CommandDocHelper {

    /**
     * Get an ComparisonCommand Help Doc 
     * 
     * @return text
     * 
     * @ingroup GetComparisonCommandHelp
     */
    public static function GetComparisonCommandHelp() {
     return <<<Help
    <info>配置文件说明</info>
        --server1   : 指定源数据库连接详细信息。如果只有一个服务器，则可以省略--server1标志
        --server2   : u指定目标数据库连接详细信息（如果它与server1不同）
        --template  : templates/simple-db-migrate.tmpl  - 指定输出模板（如果有）。默认情况下将是纯SQL
        --type      : schema或data或all  - 指定要在架构,数据或两者上执行的diff类型。schema是默认值
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
         1.Srv1.Database(down):Srv2.Database(up)
         2.Srv1.Database.table:Srv2.Database.table

        ./console  Mysql:Comparison server1.IMS_DEV:server2.IMS
         倒数第二个参数是要比较的内容。此工具可以比较数据库中的一个表或所有表（整个数据库）
         
   <info>@author 
        jhbsk(https://github.com/DBDiff/DBDiff)<info>

Help;
    }
}