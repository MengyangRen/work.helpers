<?php
namespace Src\Cmd\Schema;

use Src\Cmd\Schema\ISchema;
use Src\Util\SimpleSqlHelper;
use Src\Util\TimeTracker;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Capsule\Manager as Database;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 * 
 * @author  v.r
 * @copyright copyright http://my.oschina.net/u/1246814
 * 
 */


class UsersSchema implements ISchema
{
	/**
     * Create Data Schema
     *
     * @return mixed logs default cli-text, 
     * else Exception
     * 
     */
    public static function Create($schemaName,$io,$output) {
        TimeTracker::start();
        $Faker = FakerFactory::create();
        $no = $Faker->uuid;
        TimeTracker::title($io,'
            Build '.$schemaName.' Schema/'.$no.'
        ');
        $schema ="CREATE TABLE `".$schemaName."` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `joinDate` date NOT NULL,
              `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
              `regNo` bigint(20) NOT NULL,
              `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
              `city` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
              `url` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
              `url_crc32` int(10) unsigned NOT NULL,
              `phone` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
              `email` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
              `introduce` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=18825 DEFAULT CHARSET=utf8;";
        if (!self::IsExistsSchema($schemaName)){
            Database::connection()->getPdo()->exec(Database::raw($schema));
            TimeTracker::end();
            $diff = TimeTracker::showTimeDiff();
            TimeTracker::done($io,$no,'create-'.$schemaName.'-schema',TimeTracker::showTimeDiff(),'
                1.检查'.$schemaName.'表 [不存在]
                2.创建'.$schemaName.'表
            ',$schema);
        } else {
            TimeTracker::end();
            $diff = TimeTracker::showTimeDiff();
            TimeTracker::done($io,$no,'chcke-'.$schemaName.'-schema',TimeTracker::showTimeDiff(),'
                1.检查'.$schemaName.'表 [存在]
                2.未创建表
            ','暂无');
        }
    }
    /**
     * Schema Does it exist?
     *
     * @return mixed logs default cli-text, 
     * else Exception
     * 
     */
    public static function IsExistsSchema($schemaName) {
       return empty(Database::select("SHOW TABLES LIKE '".$schemaName."' ")) ? false : true;
    }
	/**
     * Run
     *
     * @return mixed logs default cli-text, 
     * else Exception
     * 
     */
    public static function Run($schemaName,$numberOrRows,$io,$output) {
        TimeTracker::start();
        $Faker = FakerFactory::create();
        $no = $Faker->uuid;
            TimeTracker::title($io,'
            Build <info>'.$schemaName.'</info> Schema Test Data/'.$no.' ('.$numberOrRows.'/rows)
        ');
        $numberOrRows = (int)$numberOrRows;
        $partitionNumber = 2000; 
        $numberOrRows = $numberOrRows < $partitionNumber ? $partitionNumber+1 : $numberOrRows;
        $p = ceil($numberOrRows/$partitionNumber);
        $progressBar = new ProgressBar($output, $p);
        $DataFactory = new DataFactory;
        $output->writeln('Create <info>('.$schemaName.')</info> Schema test data starting ：');
        $progressBar->start();
        $item =  0;
        do {
            $DataFactory->CreateRowData($Faker);
            if ($item % $partitionNumber == 0) {
                if (count($DataFactory->crm) > 10 ) {
                    $query = SimpleSqlHelper::Insert($schemaName,$DataFactory->crm);
                    $statement =  Database::connection()->getPdo()->prepare($query);
                    $statement->execute();
                    $statement->rowCount();
                    $DataFactory->Idestruct();
                    $progressBar->advance();
                }
            }
            $item++;
        } while ($numberOrRows > $item);
        $progressBar->finish();
        TimeTracker::end();
        print PHP_EOL;
        TimeTracker::done($io,$no,'maker-test-data',TimeTracker::showTimeDiff(),'
            共计执行'.$numberOrRows.'行
        ','暂无');

    }
	/**
     * Finish
     *
     * @return mixed logs default cli-text, 
     * else Exception
     * 
     */
    public static function  Finish($numberOrRows,$io,$output){
        print '汇总'.PHP_EOL;

    }
        
	/**
     * Idestruct
     *
     * @return mixed logs default cli-text, 
     * else Exception
     * 
     */
    public static function Idestruct() {
        print '销毁'.PHP_EOL;
    }
}
class DataFactory 
{
    public $crm = array();
    public function CreateRowData($faker) {
        $url = $faker->url;
        $this->crm[] = array (
                'joinDate'  => $faker->date('Y-m-d'),
                'name'      => $faker->name,
                'regNo'     => $faker->numberBetween(10000000, 999999999999999999),
                'address'   => $faker->address,
                'city'      => $faker->city,
                'url'       => $url,
                'url_crc32' => crc32($url),
                'phone'     => $faker->phoneNumber,
                'email'     => $faker->email,
                'introduce' => $faker->text(300),
        );
    } 
    public function GetData() {
        return $this->crm;
    }
    public function Idestruct() {
        while(!empty($this->crm)){
            $sub = array_splice($this->crm,0,1000);
            unset($sub);
        }
        unset($this->crm);
    }   
}