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
                ->addOption('show:url', null, Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Muestra la url de la suite')
                ->addOption('scan:rebuild', null, Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Scanea los mappers que tienes actualmente y genera una reconstruccion por cada uno')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->setFormatter(new Symfony\Component\Console\Formatter\OutputFormatter(true));
        $output->writeln([
            'Generador de models y mapers ',
            '=========================',
        ]);


        $output->writeln([
            'Analizando ruta de suite crm',
            '=========================',
        ]);


        // Check suite crm dir
        $suite_check = false;
        if (is_dir($GLOBALS['suite_crm_path'])) {
            $version = $GLOBALS['suite_crm_path'] . DIRECTORY_SEPARATOR . 'suitecrm_version.php';
            if (file_exists($version)) {
                define('sugarEntry', 'Generador');
                include $version;
                $output->writeln([
                    '<comment>Suite found -- version ' . $suitecrm_version . '</>',
                    '=========================',
                ]);
                $suite_check = true;
            }
        }

        if (!$suite_check) {
            $output->writeln([
                'Suite dir not found',
                'Change url in core/config.php',
                'Actual url : ' . $GLOBALS['suite_crm_path'],
                '=========================',
            ]);
            exit;
        }
        if ($input->getOption('overwrite')) {
            $overwrite = true;
        }
        if ($input->getOption('show:url')) {
            $output->writeln([
                'URL :: ' . $GLOBALS['suite_crm_path'],
            ]);
        }


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

            $this->generate(null, $overwrite);
        } else {

            if ($input->getOption('scan:rebuild')) {

                $directory = $GLOBALS['suite_crm_path'] . DIRECTORY_SEPARATOR . 'custom' . DIRECTORY_SEPARATOR . 'mappers' . DIRECTORY_SEPARATOR . 'base' . DIRECTORY_SEPARATOR;
                $mappers = scandir($directory);

                foreach ($mappers as $mapper) {
                    if (strpos($mapper, 'MapperBase') !== false) {
                        
                        $tableCamelCase = str_replace('MapperBase.php', '', $mapper);
                        $table = $this->from_camel_case($tableCamelCase);

                        $this->generate($table, $overwrite);
                    }
                }
                exit;
            }

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

                $this->generate($table, $overwrite);
            } else {
                $output->writeln([
                    '<comment>Para generar mappers y classes debes mencionar una tabla  (--table table_name ) ó usar la opcion --all</>'
                ]);
            }
        }








        // retrieve the argument value using getArgument()
//        $output->writeln('Username: ' . $input->getArgument('username'));
    }

    private function generate($table = null, $overwrite) {
        if ($table !== null) {

            $modelGenerator = new ModelGenerator($overwrite);
            $modelGenerator->setTable($table);
            $archivos = $modelGenerator->generate();

            $maperGenerator = new MapperGenerator($overwrite);
            $maperGenerator->setTable($table);
            $archivos = $maperGenerator->generate();
        } else {

            $modelGenerator = new ModelGenerator($overwrite);
            $archivos = $modelGenerator->generate();

            $maperGenerator = new MapperGenerator($overwrite);
            $archivos = $maperGenerator->generate();
        }
        
        $auditGenerate = new AuditedGenerator();
        $auditGenerate->setTable($table);
        $archivos = $auditGenerate->generate();
    }

    private function from_camel_case($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

}
