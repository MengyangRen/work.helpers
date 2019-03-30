<?php
namespace Src\Cmd;

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
 *  构建千万级项目数据 
 * @author  v.r
 * @copyright copyright http://my.oschina.net/u/1246814
 * 
 */

class MakeSchemaCommand extends Command
{  



   /**
     *Registration Command Service
     *
     * @return mixed error default NULL
     * 
     */
    protected function configure()
    {

        $this->setName('Mysql:MakeSchema')
             ->setDescription('Build user test data（支持多进程）')
             ->setHelp('
                1.This command creates a false data item for the datasheet.（支持多进程）
                2.可以使用也可以使用 TPCC-MySQL（构建测试）
                3.参考（https://blog.csdn.net/jswangchang/article/details/81317741）')
             ->addArgument('schemaName', InputArgument::REQUIRED, 'schema name 数据表名称')
             ->addArgument('numberOfRows', InputArgument::OPTIONAL,'Build fake data entry 条目');
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
        $numberOfRows = $input->getArgument('numberOfRows');
        if (!$numberOfRows) {
            $io = new SymfonyStyle($input, $output);
            $io->error('<numberOfRows> Parameter cannot be empty');
            exit;
        }
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
        $numberOfRows = $input->getArgument('numberOfRows');
        $schemaName = $input->getArgument('schemaName');
        $io = new SymfonyStyle($input, $output);
        $schema ='Src\Cmd\Schema\\'.ucwords($schemaName).'Schema';
        if (!class_exists($schema)) {
            $io->error('unable to load class: '.$schema.',Please check the parameters');
            exit;
        }  
        $schema::Create($schemaName,$io,$output);
        $schema::Run($schemaName,$numberOfRows,$io,$output);
    }
}