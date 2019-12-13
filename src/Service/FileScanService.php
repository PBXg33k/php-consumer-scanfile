<?php

namespace App\Service;

use Pbxg33k\MessagePack\Message\CheckVideoMessage;
use Pbxg33k\MessagePack\Message\ScanDirectoryMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class FileScanService
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        MessageBusInterface $messageBus,
        LoggerInterface $logger
    )
    {
        $this->messageBus = $messageBus;
        $this->logger = $logger;
    }

    public function handle(string $path)
    {
        $fileInfo = new \SplFileInfo($path);

        switch ($fileInfo->getType()) {
            case 'dir':
                $this->processDirectory($path);
                break;
            case 'file':
                $this->processFile($path);
                break;
            default:
                throw new \Exception('Type not supported. Got: '. $fileInfo->getType());
        }
    }

    public function processDirectory(string $directory)
    {
        foreach(new \DirectoryIterator($directory) as $fileInfo) {
            if($fileInfo->isDot()) {
                continue;
            }

            if($fileInfo->isDir()) {
                $this->messageBus->dispatch(new ScanDirectoryMessage($fileInfo->getRealPath()));
            } elseif($fileInfo->isFile()) {
                $this->processFile($fileInfo->getRealPath());
            }
        }
    }

    public function processFile(string $path)
    {
        if(strpos(mime_content_type($path), 'video') !== false) {
            $this->messageBus->dispatch(new CheckVideoMessage($path));
        }
    }
}
