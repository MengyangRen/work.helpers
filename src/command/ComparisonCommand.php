<?php
namespace Src\Cmd;

use DBDiff\DBDiff;
use Src\Util\SimpleTableHelper;
use Src\Util\CommandDocHelper;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Style\SymfonyStyle;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *  数据库比对服务 
 *  
 * @author  v.r
 * @copyright copyright http://my.oschina.net/u/1246814
 * 
 */
class ComparisonCommand extends Command
{  

   /**
     *Registration Command Service
     *
     * @return mixed error default NULL
     * 
     */
    protected function configure()
    {

        $this->setName('Mysql:Comparison')
             ->setDescription('Database comparison service')
             ->setHelp(CommandDocHelper::GetComparisonCommandHelp())
             ->addArgument('instruct', InputArgument::REQUIRED, 'Run alignment instruction');
        $this->addOption(
                'config',
                'c',
                InputOption::VALUE_REQUIRED,
                'compare service profile path',
                './src/config/DbdiffConfig.yml');
        $this->addOption(
                'outpath',
                'op',
                InputOption::VALUE_REQUIRED,
                'Compare results output file path',
                './src/data/end2end/migration_actual');


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
        (new SymfonyStyle($input, $output))->section('MySql Database Config Set Checking ?');   
        SimpleTableHelper::SvrConfigTable($output,Yaml::parse($input->getOption('config')));
        SimpleTableHelper::IgnoreSchemaTable($output,Yaml::parse($input->getOption('config')));
        SimpleTableHelper::IgnoreFieldsTable($output,Yaml::parse($input->getOption('config')));
    }

   /**
     * Execute Command Service
     *s
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
        $yaml = $input->getOption('config');
        $outpath = $input->getOption('outpath');
        $instruct = $input->getArgument('instruct');
        if (!(new SymfonyStyle($input, $output))
            ->confirm(
            'Are you sure you want to starting performing the comparison ?
            ('.$instruct.')'
            ,
            false
        )) return false;
        $GLOBALS['argv'] = [
            "",
            "--config=$yaml",
            "--output=$outpath"."_".time(),
        /*    "--type=schema",*/
            "$instruct"
        ];
        $dbdiff = new DBDiff;
        $dbdiff->run();
    }
}