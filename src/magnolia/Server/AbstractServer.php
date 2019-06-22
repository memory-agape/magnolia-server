<?php
namespace Magnolia\Server;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Magnolia\Utility\Functions;

abstract class AbstractServer
{
    protected $loggerChannelName = 'none';
    protected $logger;
    protected $loggerLevel = Logger::INFO;

    public function __construct()
    {
        $this->logger = Functions::getLogger(
            $this->loggerChannelName,
            $this->loggerLevel,
        );
    }

    abstract public function run(): void;
}
