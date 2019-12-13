<?php


namespace App\MessageHandler;

use App\Service\FileScanService;
use Pbxg33k\MessagePack\Message\ScanDirectoryMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ScanDirectoryMessageHandler implements MessageHandlerInterface
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var FileScanService
     */
    private $fileScanService;

    public function __construct(
        MessageBusInterface $messageBus,
        FileScanService $fileScanService
    )
    {
        $this->messageBus = $messageBus;
        $this->fileScanService = $fileScanService;
    }

    public function __invoke(ScanDirectoryMessage $message)
    {
        $this->fileScanService->processDirectory($message->getPath());
    }
}
