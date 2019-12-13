<?php

namespace App\Command;

use App\Entity\Company;
use App\Service\FileScanService;
use App\Service\MediaProcessorService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    /**
     * @var FileScanService
     */
    private $fileScanService;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        LoggerInterface $logger,
        FileScanService $fileScanService,
        ?string $name = null
    ) {
        $this->fileScanService = $fileScanService;
        $this->logger = $logger;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Add a short description for your command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->fileScanService->handle('/media');

        var_dump($this->fileScanService->getTypes());

        return 0;
    }
}
