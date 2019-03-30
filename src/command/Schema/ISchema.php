<?php
namespace Src\Cmd\Schema;

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *  定义Schema接口
 * 
 * @author  v.r
 * @copyright copyright http://my.oschina.net/u/1246814
 * 
 */
interface ISchema
{
    public static function Create($table,$io,$output);
    public static function Run($Schema,$numberOrRows,$io,$output);
    public static function Finish($numberOrRows,$io,$output);
    public static function Idestruct();
}
