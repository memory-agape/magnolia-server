<?php
require __DIR__ . '/../kernel.php';

try {
    (new \Magnolia\Main())
        ->register(\Magnolia\Server\API\Api::class)
        ->run();

} catch (\Exception | Error $e) {
    // Caught Fatal error
    $errstr = $e->getMessage();
    $errline = $e->getLine();
    $errfile = $e->getFile();

    printf("\e[35m$errstr\e[39m\n");
    printf("\e[35m  Line: $errline\e[39m\n");
    printf("\e[35m  File: $errfile\e[39m\n");
}