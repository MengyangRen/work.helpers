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




use Faker\Factory as FakerFactory;

class DemoCommand extends Command
{

    protected function configure()
    {
        $this->setName('Mysql:Demo')
             ->setDescription('测试Demo')
             ->setHelp('此命令为数据表创建虚假数据项..');

      /*       $this->addArgument(
        'names',
        InputArgument::IS_ARRAY | InputArgument::REQUIRED,
        'Who do you want to greet (separate multiple names with a space)?'
    );

          $this->addOption(
        'iterations',
        'i',
        InputOption::VALUE_REQUIRED,
        'How many times should the message be printed?',
        1
    );*/
          /*$this->addArgument(
            'names',
            InputArgument::IS_ARRAY,
            'Who do you want to greet (separate multiple names with a space)?'
            );*/

           $this->addArgument('name', InputArgument::REQUIRED, '构建数据表名称');
           $this->addArgument('user', InputArgument::REQUIRED, '构建数据表名称');
           $this->addOption(
                'bar',
                'b',
                InputOption::VALUE_REQUIRED,
                '运行执行数',
                1);

           $this->addOption(
                'cat',
                's',
                InputOption::VALUE_REQUIRED,
                '运行执行数',
                'prc');
      
    }

    /**
     * 初始化检查
     * @param  InputInterface  $input  [description]
     * @param  OutputInterface $output [description]
     * @return [type]                  [description]
     */
    public function initialize(InputInterface $input, OutputInterface $output) {
        print 'xxxx';
    }
    public function interact(InputInterface $input, OutputInterface $output) {
        print 'YYYYYY';
    } 
    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $name =$input->getArgument('name');
        $user =$input->getArgument('user');
        $iterations =$input->getOption('bar');
        $c =$input->getOption('cat');
        var_dump($name);
        var_dump($user);
        var_dump($iterations);
        var_dump($c);
        
   //     die;

    //$bar = $input->getOption('bar');
    //var_dump($bar);

    var_dump($name);


        $faker = FakerFactory::create();
        $io = new SymfonyStyle($input, $output);
        $io->title('Lorem Ipsum Dolor Sit Amet');
        $io->section('Adding a User');
        // ...
        $io->section('Generating the Password');   
        $output->writeln(array(
            '',
            '<info>Example: php insert-into-database.php [numberOfRows]</>',
            '<info>==========================</>',
            '',
        ));

        $io->listing(array(
            '<info>Element #1 Lorem ipsum dolor sit amet</>',
            '<info>Element #2 Lorem ipsum dolor sit amet</>',
            '<info>Element #3 Lorem ipsum dolor sit amet</>',
        ));
        $io->table(
            array('Header 1', 'Header 2'),
            array(
            array('Cell 1-1', 'Cell 1-2'),
            array('Cell 2-1', 'Cell 2-2'),
            array('Cell 3-1', 'Cell 3-2'),
        )
        );

        $io->note('Lorem ipsum dolor sit amet');


        $io->note(array(
            'Lorem ipsum dolor sit amet',
            'Consectetur adipiscing elit',
            'Aenean sit amet arcu vitae sem faucibus porta',
        ));

/*        $v = $io->ask('What is your name?');
        $io->ask('Where are you from?', 'United States');*/

var_dump($v);
        $io->progressStart(1000000000000);
        for ($i = 0; $i <100 ; $i++) { 
            $io->progressAdvance();  
            # code...
        }
     //   $io->progressFinish(); 


         //$io->progressFinish(); 
$io->success('Lorem ipsum dolor sit amet');
$io->error('Lorem ipsum dolor sit amet');

    // displays a 100-step length progress bar
    //$io->progressStart(100);

        $output->writeln([
            '',
            'User Creator',
            '============',
            '',
        ]);

        //绿色字体
        $output->writeln('<info>- foo</info>');
        // 黄色 text
        $output->writeln('<comment>- foo</comment>');
        // black text on a cyan background
        $output->writeln('<question>- foo</question>');
        // white text on a red background
        $output->writeln('<error>- foo</error>');

        $output->writeln('tableName: '.$input->getArgument('tableName'));
        $output->writeln('numberOfRows: '.$input->getArgument('numberOfRows'));
        $output->writeln('User successfully generated!');

        $style = new OutputFormatterStyle('red', 'yellow', array('bold', 'blink'));
        $output->getFormatter()->setStyle('fire', $style);
        $output->writeln('<fire>foo</fire>');

        // green text
$output->writeln('<fg=green>foo</>');

// black text on a cyan background
$output->writeln('<fg=black;bg=cyan>foo</>');

// bold text on a yellow background
$output->writeln('<bg=yellow;options=bold>foohhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh</>');

// bold text with underscore
$output->writeln('<options=bold,underscore>foo</>');

        /*
        // 你想要做的任何操作
        $optional_argument = $input->getArgument('optional_argument');
        $output->writeln('creating...');
        $output->writeln('created ' . $input->getArgument('name') . ' model success !');

        if ($optional_argument)
            $output->writeln('optional argument is ' . $optional_argument);

        $output->writeln('the end.');*/
    }
}