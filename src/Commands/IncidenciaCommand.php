<?php

namespace App\Commands;

use App\Entity\Incidencia;
use App\Managers\IncidenciaManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class IncidenciaCommand extends Command
{
    protected static $defaultName = 'app:incidencia';
    private $incidenciaManager;

    public function __construct(IncidenciaManager $incidenciaManager)
    {
        $this->incidenciaManager = $incidenciaManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Descripción del comando')
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new Question('Nombre de la incidencia: ', 'incidencia');
        $titulo = $helper->ask($input, $output, $question);

        $question = new Question('Descripción de la incidencia: ', '');
        $descripcion = $helper->ask($input, $output, $question);

        $fechaCreacion = new \DateTime();
        var_dump($fechaCreacion->getTimestamp());
        $incidencia = new Incidencia();

        $incidencia->setTitulo($titulo);
        $incidencia->setDescripcion($descripcion);
        $incidencia->setFechaCreacion($fechaCreacion->getTimestamp());
        $incidencia->setResuelta('0');
        $incidencia->setFechaResolucion(\DateTime::createFromFormat('Y-m-d H:i:s', strtotime('now')));

        $this->incidenciaManager->create($incidencia);


    }
}