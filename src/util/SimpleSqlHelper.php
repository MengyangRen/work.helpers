<?php
namespace Src\Util;

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *  定义Sql语句简单生成助手
 * 
 * @author  v.r
 * @copyright copyright http://my.oschina.net/u/1246814
 * 
 */

class SimpleSqlHelper {

    /**
     * Create Insert Sql
     *
     * @return mixed logs default cli-text, 
     * else Exception
     * 
     */
    public static function Insert($table,$items = array()) {
        $valSql = '';
        $len = count($items);
        $num = 0;
        $fields = array_keys($items[$num]);

        $fields = array_map(function($field) {
            return "`" . $field . "`";
        }, $fields);
        foreach ($items as $key => $item) {
            $num +=1;
            $valSql .= SimpleSqlHelper::_Insert($item);
            if ($len != $num) 
                $valSql .=",";
            else 
                $valSql .=';';
        }
       return 'INSERT INTO ' . $table . ' (' . implode(',', $fields) . ') VALUES '.$valSql;
    }

    public static function _Insert($item = array()) {
        $values = array_values($item);
        
        $values = array_map(function($value) {
           $value = addslashes(stripslashes($value));
            return "'" . $value . "'";
        }, $values);

        return '(' . implode(',', $values) .')';
    }
}