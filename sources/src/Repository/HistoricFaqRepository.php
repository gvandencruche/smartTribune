<?php

namespace App\Repository;

use App\Entity\ExportCSV;
use App\Entity\HistoricFaq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method HistoricFaq|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoricFaq|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoricFaq[]    findAll()
 * @method HistoricFaq[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoricFaqRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, HistoricFaq::class);
        $this->manager = $manager;
    }
  

    /**
     * Export CSV
     *
     * @param [type] $faq
     * @return void
     */
    public function exportCSV()
    {
        $repository = $this->manager->getRepository('App:HistoricFaq');
        $donneefaq = $repository->findAll();
        $stream = __DIR__."/exportHistoricFaq.csv";
        $exportCSV = new ExportCSV(new HistoricFaq,$donneefaq,$stream);
        $exportCSV->generateCSV();
       
    }

}
