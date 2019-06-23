<?php
namespace Magnolia\Server\API;

use Magnolia\Contract\ServerInterface;
use Magnolia\Exception\ServerInterruptException;
use Monolog\Logger;
use Magnolia\Server\GenericServer;

final class EnvInfo extends GenericServer implements ServerInterface
{
    protected $loggerChannelName = 'APIEnvInfo.Server';

    public function getServerName(): string
    {
        return 'APIEnvInfo';
    }

    public function getListenHost(): string
    {
        return getenv('API_ENV_INFO_LISTEN_HOST');
    }

    public function getListenPort(): int
    {
        return getenv('API_ENV_INFO_LISTEN_PORT');
    }

    public function getInstantiationClientClassName(): ?string
    {
        return \Magnolia\Client\API\EnvInfo::class;
    }
}
