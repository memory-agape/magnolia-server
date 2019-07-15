<?php
namespace Magnolia\Traits;

use Magnolia\Contract\ClientInterface;
use Magnolia\Stream\Stream;
use Swoole\Coroutine\Channel;

/**
 * @property-read ClientInterface|Stream $client
 */
trait ProcedureManageable
{
    public function pushToProcedureStack(
        string $procedureTargetClass,
        int $key,
        callable $callback,
        ...$parameters
    ) {
        /**
         * @var Channel $procedure
         */
        $procedure = $this->client->getProcedures()[$procedureTargetClass];
        $procedure->push([
            $callback,
            $key,
            $parameters,
        ]);
    }

    public function proceedProcedure(int $key, ...$anyParameters): void
    {
        /**
         * @var Channel $procedure
         */
        $procedure = $this->procedures[static::class] ?? null;
        if ($procedure === null) {
            return;
        }

        $restoreProcedures = [];
        while ($procedure->isEmpty()) {
            [ $callback, $targetKey, $parameters ] = $task = $procedure->pop();
            if ($targetKey !== $key) {
                $restoreProcedures[] = $procedure->pop();
                continue;
            }
            $callback(
                $procedure,
                ...$parameters,
                ...$anyParameters
            );
        }

        foreach ($restoreProcedures as $restoreProcedure) {
            $procedure->push(
                $restoreProcedures
            );
        }
    }
}
