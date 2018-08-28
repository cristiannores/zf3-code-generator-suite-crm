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
                ->addOption('table', 't', Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Nombre de la tabla en base de datos')
                ->addOption('type', 'tp', Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Tipo (mapper | models | audit | all) ', 'all')
                ->addOption('all', null, Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Agregar todas las tablas')
                ->addOption('cstm', null, Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Inlcuir tablas cstm')
                ->addOption('overwrite', null, Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Sobreescribe las tablas existentes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->setFormatter(new Symfony\Component\Console\Formatter\OutputFormatter(true));
        $output->writeln([
            'Generando models y mapers ',
            '=========================',
        ]);


        $all = $input->getOption('all');
        $overwrite = false;
        if ($input->getOption('overwrite')) {
            $overwrite = true;
        }
        if ($all) {
            $output->writeln([
                '<comment>Generando Totas las tablas .... espere un momento</>',
                '===============================',
            ]);

            $modelGenerator = new ModelGenerator($overwrite);
            $archivos = $modelGenerator->generate();



            $maperGenerator = new MapperGenerator($overwrite);
            $archivos = $maperGenerator->generate();
        } else {
            $table = $input->getOption('table');

            if ($table) {
                $output->writeln([
                    'Tabla seleccionada',
                    '=================',
                    $table
                ]);
                $output->writeln([
                    '=================',
                    "<comment>Generando</>",
                    '=================',
                    $table
                ]);
                $modelGenerator = new ModelGenerator($overwrite);
                if ($table) {
                    $modelGenerator->setTable($table);
                }

                $archivos = $modelGenerator->generate();


                $maperGenerator = new MapperGenerator($overwrite);
                if ($table) {
                    $maperGenerator->setTable($table);
                }
                $archivos = $maperGenerator->generate();
            } else {
                $output->writeln([
                    'DEBE SELECCIONAR UNA TABLA'
                ]);
            }
        }








        // retrieve the argument value using getArgument()
//        $output->writeln('Username: ' . $input->getArgument('username'));
    }

}
