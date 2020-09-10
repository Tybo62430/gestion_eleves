<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\FeriesApi\FerieFunction ;

/**
 * Description of InsertFeriesInDb
 *
 * @author busipart
 */
class UpdateFeriesCommand extends Command {

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:update-feries';
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;

        parent::__construct();
    }

    protected function configure() {
        $this
                ->setDescription('Met a jour les jours feries stocker en base de donnée.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $em = $this->em;

        $ferieFunction = new FerieFunction($em);
        $ferieFunction->cleanTable();
        $ferieFunction->InsertFeries();
    }

}
