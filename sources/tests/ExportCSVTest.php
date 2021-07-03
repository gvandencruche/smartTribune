<?php

namespace App\Tests;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\FAQ;

class ExportCSVTest extends KernelTestCase
{
    protected $FAQRepository;

    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->FAQRepository = $this->entityManager->getRepository(FAQ::class);
    }

    public function testSomething(): void
    {
        $kernel = self::bootKernel();
        $response = $this->FAQRepository->exportCSV();
       
        $this->assertSame('test', $kernel->getEnvironment());
        //$routerService = self::$container->get('router');
        //$myCustomService = self::$container->get(CustomService::class);
    }
}
