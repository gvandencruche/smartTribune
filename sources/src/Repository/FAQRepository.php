<?php

namespace App\Repository;

use App\Entity\ExportCSV;
use App\Entity\AnswersFAQ;
use App\Entity\HistoricFaq;
use App\Entity\FAQ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @method FAQ|null find($id, $lockMode = null, $lockVersion = null)
 * @method FAQ|null findOneBy(array $criteria, array $orderBy = null)
 * @method FAQ[]    findAll()
 * @method FAQ[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FAQRepository extends ServiceEntityRepository
{
    private $manager;

  
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, FAQ::class);
        $this->manager = $manager;
    }

    /**
     * Sauvegarde la FAQ et ses réponses
     *
     * @param [type] $faq
     * @return void
     */
   public function saveFAQ($faq)
   {
     try
     {
        $newfaq = new FAQ();
        $newfaq
            ->setTitle($faq['title'])
            ->setPromoted($faq['promoted'])
            ->setStatus($faq['status']);
        foreach($faq['answers'] as $answers)
        {
            $newAnswer = new AnswersFAQ();
            $newAnswer->setChannel($answers['channel']);
            $newAnswer->setBody($answers['body']);
            $newfaq->addAnswer($newAnswer);
            $this->manager->persist($newAnswer);
        }
        $this->manager->persist($newfaq);
        $this->manager->flush();
        return true;
     }
     catch(Throwable $e)
     {
         return ['status' => 'Error!','message' => $e->getMessage()];
     }
   }

   /**
     * Sauvegarde la FAQ et ses réponses
     *
     * @param [type] $faq
     * @return void
     */
    public function updateFAQ($faq)
    {
      try
      {
        $historic = new HistoricFaq();
        $repository = $this->manager->getRepository('App:FAQ');
        $updatefaq = $repository->find($faq['id']);

        if(!empty($faq['title']))
        {
          $historic->setTitle($faq['title']);
          $updatefaq->setTitle($faq['title']);
        }
        if(!empty($faq['status']))
        {
          $historic->setStatus($faq['status']);
          $updatefaq->setStatus($faq['status']);
        }
        $updatefaq->addHistoricFaq($historic);
        $this->manager->persist($historic);
        $this->manager->persist($updatefaq);
        $this->manager->flush();
        return true;
      }
      catch(Throwable $e)
      {
          return ['status' => 'Error!','message' => $e->getMessage()];
      }
    }

    /**
     * Export CSV
     *
     * @param [type] $faq
     * @return void
     */
    public function exportCSV()
    {
        $exportCSV = new ExportCSV(new FAQ,$this->manager->getRepository('App:FAQ')->findAll(),$_SERVER['PWD'].'/files/exportFaq.csv');
        $exportCSV->generateCSV();
       
    }


}
