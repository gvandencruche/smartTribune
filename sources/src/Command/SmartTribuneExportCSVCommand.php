<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\QueryBuilder;
use App\Entity\FAQ;
use App\Entity\HistoricFaq;
use App\Repository\FAQRepository;
use App\Repository\HistoricFaqRepository;

class SmartTribuneExportCSVCommand extends Command
{
    protected static $defaultName = 'smartTribune:exportCSV';
    protected static $defaultDescription = 'Add a short description for your command';
    protected $FAQRepository;
    protected $HistoricFaqRepository;

    private $manager;
    public function __construct(FAQRepository $FAQRepository, HistoricFaqRepository $HistoricFaqRepository)
    {
        parent::__construct();
        $this->HistoricFaqRepository = $HistoricFaqRepository;
        $this->FAQRepository = $FAQRepository;
       
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
        //
        }
        
        $this->FAQRepository->exportCSV();
       // $this->HistoricFaqRepository->exportCSV();

        

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
