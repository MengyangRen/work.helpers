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
 *  多进程开启服务命令（用于处理其他耗时服务） 
 * @author  v.r
 * @copyright copyright http://my.oschina.net/u/1246814
 * 
 */

class MultiProcessCommand extends Command
{  



   /**
     *Registration Command Service
     *
     * @return mixed error default NULL
     * 
     */
    protected function configure()
    {

 /*       $this->setName('Process:Execute')
             ->setDescription('This is a multiprocess manager.')
             ->setHelp('Manage to open task commands that support multi-proc')
             ->addArgument('cmdName', InputArgument::REQUIRED, '命令名称')
             ->addArgument('numberOfRows', InputArgument::OPTIONAL,'Build fake data entry 条目');*/
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

    }
}