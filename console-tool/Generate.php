<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command {

    protected function configure() {
        $this
                // the name of the command (the part after "bin/console")
                ->setName('run')

                // the short description shown while running "php bin/console list"
                ->setDescription('Genera models y mappers para suite crm')

                // the full command description shown when running the command with
                // the "--help" option
                ->setHelp('This command allows you to generate model and mapper')
                ->addArgument('table')
                ->addOption('all', null, Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Agregar todas las tablas')
                ->addOption('cstm', null, Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Inlcuir tablas cstm')
                ->addOption('overwrite', null, Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Sobreescribe las tablas existentes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $outputStyle = new Symfony\Component\Console\Formatter\OutputFormatterStyle('red', 'yellow', array('bold', 'blink'));
        $output->getFormatter()->setStyle('fire', $outputStyle);
        $output->writeln([
            'Generando models y mapers ',
            '=========================',
        ]);


        $table = $input->getArgument('table');

        if ($table) {
            $output->writeln([
                'Tabla seleccionada',
                '=================',
                $table
            ]);
            $output->writeln([
                '=================',
                'Generando',
                '=================',
                $table
            ]);
            $modelGenerator = new ModelGenerator();
            if ($table) {
                $modelGenerator->setTable($table);
            }

            $archivos = $modelGenerator->generate();
            foreach ($archivos as $a) {
                $output->writeln('Archivo generado : ' . $a);
            }

            $maperGenerator = new MapperGenerator();
            if ($table) {
                $maperGenerator->setTable($table);
            }
            $archivos = $maperGenerator->generate();

            foreach ($archivos as $a) {
                $output->writeln('Archivo generado : ' . $a);
            }
        }else{
             $output->writeln([
                'DEBE SELECCIONAR UNA TABLA'
            ]);
             
        }






        // retrieve the argument value using getArgument()
//        $output->writeln('Username: ' . $input->getArgument('username'));
    }

}
