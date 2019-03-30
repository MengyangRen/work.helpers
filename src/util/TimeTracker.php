<?php
namespace Src\Util;

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *  定义记录时间工具 OR 控制台显示
 * 
 * @author  v.r
 * @copyright copyright http://my.oschina.net/u/1246814
 * 
 */

class TimeTracker
{
    public static $startTime;
    public static $endTime;

    public static function start()
    {
        self::$startTime = new \DateTime('now');
    }

    public static function end()
    {
        self::$endTime = new \DateTime('now');
    }

    public static function getTimeDiff()
    {
        return self::$startTime->diff(self::$endTime);
    }

    public static function showTimeDiff()
    {
        $diff = self::getTimeDiff();
        return $diff;
    }

    public static function title($io,$met) {
         $io->title($met);   
    }
    
    public static function done($io,$no,$act,$diff,$em,$emt) {
        $io->listing(array(
            '<info>【编号:】</>'.$no.'',
            '<info>【操作:】</>'.$act.'',
            '<info>【耗时:】</>'.$diff->i.'m,'.$diff->s.'s',
            '<info>【执行说明:】</>'.$em.'',
            '<info>【执行内容:】</>'.$emt.'',
        ));
    }
}
