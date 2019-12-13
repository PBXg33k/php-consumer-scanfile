<?php
namespace App\MessageHandler;

use App\Service\FileScanService;
use Pbxg33k\MessagePack\Message\ScanFileMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ScanFileMessageHandler implements MessageHandlerInterface
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

    public function __invoke(ScanFileMessage $message)
    {
        $this->fileScanService->processFile($message->getFile());
    }
}
