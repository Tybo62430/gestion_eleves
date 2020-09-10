<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\FeriesApi;

use AppBundle\Entity\JourFerie;
use AppBundle\FeriesApi\FeriesApi;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of FerieFunction
 *
 * @author busipart
 */
class FerieFunction {
    
    private $em;
    
    public function __construct(EntityManagerInterface $em) {
       $this->em = $em;
    }

    public function cleanTable() {

        $em = $this->em;

        $allJoursFeries = $em->getRepository('AppBundle:JourFerie')->findAll();

        foreach ($allJoursFeries as $value) {
            $em->remove($value);
            $em->flush();
        }
    }

    public function InsertFeries() {

        $em = $this->em;

        $feriesApi = new FeriesApi();
        $joursFeries = $feriesApi->getCurrent();

        foreach ($joursFeries as $value) {
            $jourFerie = new JourFerie();
            $date = new \DateTime($value[0]);
            $jourFerie->setDate($date)
                    ->setLibelle($value[1]);

            $em->persist($jourFerie);
            $em->flush();
        }
    }

}
